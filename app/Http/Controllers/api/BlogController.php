<?php

// Api Controller
// Kullanıcı girişleri api.php dosyasında kontrol ediliyor.
// Resourceler isteğe göre çoğaltılıp, şekillendirilebilir. Tek bir resource üzerinden gidildi.

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

//resource
use App\Http\Resources\BlogResource;
use App\Http\Resources\AlertResource;

//models
use App\Models\User;
use App\Models\Blog;
use App\Models\Blog_to_categories;
use App\Models\Blog_to_tags;
use App\Models\Blog_to_comments;

class BlogController extends Controller
{

    public function index()
    {
        $blog = Blog::whereUserId(Auth::id())->orderby('id', 'desc')->get();
        return BlogResource::collection($blog);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'detail' => 'required|string',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->detail = $request->detail;
        $blog->categories = $request->categories; // single
        $blog->status = $request->status;
        $blog->user_id = Auth::id();
        $blog->save();

        //multiple categories
        /*
        if (isset($request->categories) && count($request->categories)>0) {
            foreach ($request->categories as $rs) {
                Blog_to_categories::create([
                    'blog_id' => $blog->id,
                    'category_id' => $bs,
                    'user_id' => Auth::id(),
                ]);
            }
        }
        */
        //multiple categories

        //Tags
        if (isset($request->tags) && count($request->tags)>0) {
            foreach ($request->tags as $rs) {
                Blog_to_tags::create([
                    'blog_id' => $blog->id,
                    'tag_is' => $bs,
                    'user_id' => Auth::id(),
                ]);
            }
        }
        //Tags

        if ($blog->save()) {
            return new BlogResource($blog);
        }else {
            return response()->json(['status' => 'error', 'message' => 'Bir hata oluştu. Lütfen yöneticiniz ile iletişime geçiniz.']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $blog = Blog::whereId($id)->whereUserId(Auth::id())->first();

        if ($blog) {
            $request->validate([
                'title' => 'required|string',
                'detail' => 'required|string',
            ]);
            $blog->title = $request->title;
            $blog->detail = $request->detail;
            $blog->categories = $request->categories; // single
            $blog->status = $request->status;
            $blog->save();

            //multiple categories
            /*
            if (isset($blog->categories) && count($blog->categories)>0) {
                $bc = Blog_to_categories::whereBlogId($id)->delete();
                foreach ($blog->categories as $bs) {
                    Blog_to_categories::create([
                        'blog_id' => $blog->id,
                        'category_id' => $bs,
                        'user_id' => Auth::id(),
                    ]);
                }
            }
            */
            //multiple categories

            //Tags
            if (isset($request->tags) && count($request->tags)>0) {
                $bc = Blog_to_tags::whereBlogId($id)->delete();
                foreach ($request->tags as $rs) {
                    Blog_to_tags::create([
                        'blog_id' => $blog->id,
                        'tag_is' => $bs,
                        'user_id' => Auth::id(),
                    ]);
                }
            }
            //Tags

            if ($blog->save()) {
                return new BlogResource($blog);
            }else {
                return response()->json(['status' => 'error', 'message' => 'Bir hata oluştu. Lütfen yöneticiniz ile iletişime geçiniz.']);
            }
        }else {
            return response()->json(['status' => 'error', 'message' => 'İlgili blog yazısı için işlem yetkiniz yok.']);
        }

    }

    public function destroy(string $id)
    {
        $blog = Blog::whereId($id)->whereUserId(Auth::id())->first();
        if ($blog) {
            $blog->delete()
            if ($blog->delete()) {
                $bc = Blog_to_categories::whereBlogId($id)->delete();
                return response()->json(['status' => 'success', 'message' => 'Blog yazısı başarıyla silindi.']);
            }else {
                return response()->json(['status' => 'error', 'message' => 'Bir hata oluştu. Lütfen yöneticiniz ile iletişime geçiniz.']);
            }
        }else {
            return response()->json(['status' => 'error', 'message' => 'İlgili blog yazısı için işlem yetkiniz yok.']);
        }
    }

    // extra

    // ***** KATEGORİLER ve ETİKETLER aynı anda burada filtreliyor. *****
    public function postBlogFilter(Request $request) {

        if (isset($request->cat) || isset($request->tags)) {
            $blog = Blog::orderby('id', 'desc');
        }else {
            return response()->json(['status' => 'error', 'message' => 'Seçim yapılmadı.']);
        }

        // Teklif kategori için genel filtreleme
        if (isset($request->tags)) { // etiket varsa öncelikli
            $bt = Blog_to_tags::select('blog_id')->whereIn('tag_id', $request->tag)->whereUserId(Auth::id())->get();
            $blog = $blog->whereIn('id', $bt);
        }
        if (isset($request->cat)) { $blog = $blog->whereCategories($request->cat); }
        
        // Teklif kategori için genel filtreleme

        // Çoklu kategori için genel filtreleme
        /*
        if (isset($request->tags)) {
            $bt = Blog_to_tags::select('blog_id')->whereIn('tag_id', $request->tag)->whereUserId(Auth::id())->get();
        }
        if (isset($request->cat)) {
            $bc = Blog_to_categories::select('blog_id')->whereIn('category_id', $request->cat)->whereUserId(Auth::id())->get();
        }

        $merge = $bt->merge($bc);
        $filter = $merge->unique();

        $blog = $blog->whereIn('id', $filter);
        */
        // Çoklu kategori için genel filtreleme

        $blog->get();

        if (count($blog) > 0) {
            return new BlogResource($blog);
        }else {
            return response()->json(['status' => 'error', 'message' => 'Aramaya ait bir sonuç bulunamadı.']);
        }
        
    }

    public function postComment(Request $request) {
        $blog = Blog::findOrFail($request->id);
        $c = Blog_to_comments::create([
            'blog_id' => $blog->id,
            'user_id' => $request->user_id,
            'comment' => $request->comment,
        ]);
        return new BlogResource($c);
    }

}
