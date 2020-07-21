<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//-----------------------------------------------------------------------------------------------
//                                 Login 
//-----------------------------------------------------------------------------------------------



    /*
    |-------------------------------------------------------------------------------
    |  User Login
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/login
    | Controller:     ApiController@login
    | Method:         POST
    | Description:    Access the application
    | Permission:     Admin and Client
    | Request:        username / password 
    | Response:       'success', 'token'
    */  
        Route::post('login', 'ApiController@login');

    Route::group(['middleware' => 'auth.jwt'], function () {
  
    /*
    |-------------------------------------------------------------------------------
    |  Check User Login
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/login
    | Controller:     ApiController@login
    | Method:         POST
    | Description:    Access the application
    | Permission:     Admin and Client
    | Request:        username / password 
    | Response:       'id','username','role_id',
    */  
        Route::post('check-user', 'ApiController@checkUser');
    /*
    |-------------------------------------------------------------------------------
    | Register a user
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/register
    | Controller:     ApiController@register
    | Method:         POST
    | Description:    Register a new user, it could be an admin or a client
    | Permission:     Only Admin
    | Request:        username ->unique / password / role_id (1 for admin, 2 for client)
    | Response:       'success', 'token'
    */
        Route::post('register', 'ApiController@register');
    /*
    |-------------------------------------------------------------------------------
    |  User Logout
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/logout
    | Controller:     ApiController@logout
    | Method:         GET
    | Description:    User logged out and exit the application
    | Permission:     Admin and Client
    | Request:        'token'
    | Response:       'success', 'message'
    */  
        Route::get('logout', 'ApiController@logout');
  
  
//---------------------------------------------------------------------------------------------
//                                 USERS TABLE
//---------------------------------------------------------------------------------------------
      
    
    
    /*
    |-------------------------------------------------------------------------------
    |  SHOW All the registered users 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/users
    | Controller:     ApiController@index
    | Method:         GET
    | Description:    Get all the registered users that have access to the application
    | Permission:     Only Admin
    | Request:        'token'
    | Response:       'id', 'username', 'role_id', 'created_at', 'updated_at'
    */   
        Route::get('users', 'ApiController@index');
    /*
    |-------------------------------------------------------------------------------
    |  Edit a registered user by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/users/{id}
    | Controller:     ApiController@update
    | Method:         PUT
    | Description:    Update the information of a registered user
    | Permission:     Only Admin
    | Request:        'token', 'username' OR 'password' OR 'role_id' OR ALL
    | Response:       'success', 'message'-> if false
    */  
        Route::put('users/{id}', 'ApiController@update');
    /*
    |-------------------------------------------------------------------------------
    |  DELETE a registered user by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/users/{id}
    | Controller:     ApiController@destroy
    | Method:         DELETE
    | Description:    Delete the information of a registered user
    | Permission:     Only Admin
    | Request:        'token'
    | Response:       'success', 'message'-> if false
    */  
        Route::delete('users/{id}', 'ApiController@destroy');
  
  
  
//---------------------------------------------------------------------------------------------
//                                 ITEMS TABLE
//---------------------------------------------------------------------------------------------

  
  
    /*
    |-------------------------------------------------------------------------------
    |  CREATE A NEW ITEM
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/items
    | Controller:     ItemController@store
    | Method:         POST
    | Description:    CREATE a new item by submitting its informations
    | Permission:     Only Admin
    | Request:        'token', 'english_name', 'arabic_name', 'barcode', 'price', 'category_id'
    | Response:       'success', 'data' -> if true, 'message'-> if false
    */  
        Route::post('items', 'ItemController@store');
    /*
    |-------------------------------------------------------------------------------
    |  SHOW All the registered items 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/items
    | Controller:     ItemController@index
    | Method:         GET
    | Description:    Get all the registered items
    | Permission:     Admin 
    | Request:        'token'
    | Response:       'id', '', '', '', '', '',
    |                  '','' '',''
    */ 
        Route::get('items', 'ItemController@index');
    /*
    |-------------------------------------------------------------------------------
    |  SHOW a registerd item's information by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/items/{id}
    | Controller:     ItemController@show
    | Method:         GET
    | Description:    Get the registered item's information with the proper ID
    | Permission:     Only Admin
    | Request:        'token'
    | Response:       'id', '', '', '', '', '',
    |                  '','' '',''
    */ 
        Route::get('items/{id}', 'ItemController@show');
    /*
    |-------------------------------------------------------------------------------
    |  Edit a registered item by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/items/{id}
    | Controller:     ItemController@update
    | Method:         PUT
    | Description:    Update the information of a registered item
    | Permission:     Only Admin
    | Request:        'token', with information to be updated
    | Response:       'success', and 'message'-> if false
    */
        Route::put('items/{id}', 'ItemController@update');
    /*
    |-------------------------------------------------------------------------------
    |  DELETE a registered item by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/items/{id}
    | Controller:     ItemController@destroy
    | Method:         DELETE
    | Description:    DELETE the information of a registered item
    | Permission:     Only Admin
    | Request:        'token', with information to be updated
    | Response:       'success', and 'message'-> if false
    */
        Route::delete('items/{id}', 'ItemController@destroy');

    


//---------------------------------------------------------------------------------------------
//                                 CATEGORIES TABLE
//---------------------------------------------------------------------------------------------

  
  
    /*
    |-------------------------------------------------------------------------------
    |  CREATE A NEW CATEGORY
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/categories
    | Controller:     CategoryController@store
    | Method:         POST
    | Description:    CREATE a new item by submitting its informations
    | Permission:     Only Admin
    | Request:        'token', 'english_name', 'arabic_name', 'barcode', 'price', 'category_id'
    | Response:       'success', 'data' -> if true, 'message'-> if false
    */  
    Route::post('categories', 'CategoryController@store');
    /*
    |-------------------------------------------------------------------------------
    |  SHOW All the registered categories 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/categories
    | Controller:     CategoryController@index
    | Method:         GET
    | Description:    Get all the registered categories
    | Permission:     Admin 
    | Request:        'token'
    | Response:       'id', '', '', '', '', '',
    |                  '','' '',''
    */ 
        Route::get('categories', 'CategoryController@index');
    /*
    |-------------------------------------------------------------------------------
    |  SHOW a registerd category's information by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/categories/{id}
    | Controller:     CategoryController@show
    | Method:         GET
    | Description:    Get the registered category's information with the proper ID
    | Permission:     Only Admin
    | Request:        'token'
    | Response:       'id', '', '', '', '', '',
    |                  '','' '',''
    */ 
        Route::get('categories/{id}', 'CategoryController@show');
    /*
    |-------------------------------------------------------------------------------
    |  Edit a registered category by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/categories/{id}
    | Controller:     CategoryController@update
    | Method:         PUT
    | Description:    Update the information of a registered category
    | Permission:     Only Admin
    | Request:        'token', with information to be updated
    | Response:       'success', and 'message'-> if false
    */
        Route::put('categories/{id}', 'CategoryController@update');
    /*
    |-------------------------------------------------------------------------------
    |  DELETE a registered category by ID 
    |-------------------------------------------------------------------------------
    | URL:            http://127.0.0.1:8000/api/categories/{id}
    | Controller:     CategoryController@destroy
    | Method:         DELETE
    | Description:    DELETE the information of a registered item
    | Permission:     Only Admin
    | Request:        'token', with information to be updated
    | Response:       'success', and 'message'-> if false
    */
        Route::delete('categories/{id}', 'CategoryController@destroy');
});