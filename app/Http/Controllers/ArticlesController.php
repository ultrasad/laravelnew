<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use App\Models\Article as Articles;
use Auth;
use App\Article;
use App\Tag;
// use App\User;
// use Illuminate\Http\Request;
use Request; //use Request replace Illuminate\Http\Request
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth', ['only' => ['create', 'store']]);
      //$this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
    * Display a list of the resource.
    *
    *@return Response
    */

    public function index()
    {
      /*
      $articles = Article::lastest('published_at')
                          ->published()
                          ->get();
      //dd($articles); //dump and die
      return view('article.index', compact('articles'));
      //return $articles; //return json object
      */

      //$articles = Article::published()->get(); //pass scopePublished scope
      $articles = Article::published()->paginate(5);

      //echo '<pre>';
      //print_r($articles);
      //exit;

      return view('articles.index', compact('articles'));
    }

    /**
    * Show the form for creating a new resource.
    *
    *@return Response
    */
    public function create()
    {
        $tag_list = Tag::lists('name', 'id');
        return view('articles.create', compact('tag_list'));
    }

    /**
    * Store a newly created resource in storage.
    *
    *@return Response
    */

    /*public function store()
    {
        $input = Request::all();
        Article::create($input);
        return redirect('articles');
    }*/

    public function store(ArticleRequest $request)
    {
       /*
       $input = $request->all();
       Article::create($input);
       return redirect('articles');
       */

       //dd($request);
       //exit;

       //echo '<pre>';
       //print_r($request->all());
       //exit;

       //$input = $request->all();
       $article = new Article($request->all());
       //$article->user_id = Auth::user()->id;
       //$article->save();

       if($request->hasFile('image')){
         $image_filename = $request->file('image')
                          ->getClientOriginalName();
         $image_name = date('Ymd-His-').$image_filename;
         $public_path = 'images/articles/';
         $destination = base_path() . '/public/' . $public_path;
         $request->file('image')->move($destination, $image_name); //move file to destination
         $article->image = $public_path . $image_name; //set article image name
       }
       Auth::user()->articles()->save($article);

       //tags
       $tagsId = $request->input('tag_list');
       if(!empty($tagsId))
          $article->tags()->sync($tagsId);
      //echo '-- exit --';
      //exit;
       return redirect('articles');
    }

    /**
    * Display the speified resource.
    *
    *@param int $id
    *@return Response
    */
    public function show($id)
    {
      //echo '=> ' . $id;

      $article = Article::find($id);
      if(empty($article))
        abort(404);

      //echo '<pre>';
      //print_r($article);

      //dd($article);
      return view('articles.show', compact('article'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    *@param int $id
    *@return Response
    */
    public function edit($id)
    {
      $article = Article::find($id);
      $tag_list = Tag::lists('name', 'id');

      if(empty($article))
        abort(404);
      return  view('articles.edit', compact('article', 'tag_list'));
    }

    /**
    * Update the specified resource in storage.
    *
    *@param int $id
    *@return Response
    */
    public function update($id, ArticleRequest $request)
    {
      $article = Article::findOrFail($id);
      $article->update($request->all());

      if($request->hasFile('image')){
        $image_filename = $request->file('image')
                         ->getClientOriginalName();
        $image_name = date('Ymd-His-').$image_filename;
        $public_path = 'images/articles/';
        $destination = base_path() . '/public/' . $public_path;
        $request->file('image')->move($destination, $image_name); //move file to destination
        $article->image = $public_path . $image_name; //set article image name
        $article->save(); //update
      }

      $tagsId = $request->input('tag_list');
      if(!empty($tagsId))
        $article->tags()->sync($tagsId);
      else
        $article->tags()->detach();
      return redirect('articles');
    }

    /**
    * Remove the specifiled resource from storege.
    *
    *@param int $id
    *@return Response
    */
    public function destroy($id)
    {
      $article = Article::findOrFail($id);
      $article->delete();
      return redirect('articles');
    }
}
