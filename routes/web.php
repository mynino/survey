<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//authentication
Route::any('/', function () {
    return view('login');
});
Route::any('/login', function () {
    return view('login');
});
Route::any('/menu', function () {
    return view('menu',["user"=>session("user")]);
});
Route::any('/dash', function () {
    return view('dash');
});
Route::any('/qnaire',function(){
	return view('qnaire');
});
Route::any('/qnaireShow',function(){
	return view('qnaireShow');
});
Route::any('/qnaireToDo',function(){
	return view('qnaireToDo');
});
Route::any('/qnaireList',function(){
	return view('qnaireList');
});
Route::any('/userList',function(){
	return view('userList');
});
Route::any('/qnaireDeployedList',function(){
	return view('qnaireList');
});
Route::any('/qnaireDesign',function(){
	return view('qnaireDesign');
});
Route::any('/analyse', function () {
    return view('analyse');
});

Route::any('/loginAjax',"AuthController@loginAjax");
Route::any('/logoutAjax',"AuthController@logoutAjax");
Route::any('/userListAjax',"AuthController@userListAjax");
Route::any('/createUserAjax',"AuthController@createUserAjax");
Route::any('/editUserAjax',"AuthController@editUserAjax");
Route::any('/deleteUserAjax',"AuthController@deleteUserAjax");
Route::any('/changePwdAjax',"AuthController@changePwdAjax");

Route::any('/deleteQnaireAjax',"QnaireController@deleteQnaireAjax");
Route::any('/createQnaireAjax',"QnaireController@createQnaireAjax");
Route::any('/deployQnaireAjax',"QnaireController@deployQnaireAjax");
Route::any('/renameQnaireAjax',"QnaireController@renameQnaireAjax");
Route::any('/undeployQnaireAjax',"QnaireController@undeployQnaireAjax");
Route::any('/qnaireReadAjax',"QnaireController@qnaireReadAjax");
Route::any('/qnaireSaveAjax',"QnaireController@qnaireSaveAjax");
Route::any('/qnaireDoneAjax',"QnaireController@qnaireDoneAjax");
Route::any('/qnaireListAjax',"QnaireController@qnaireListAjax");
Route::any('/qnaireDeployedListAjax',"QnaireController@qnaireDeployedListAjax");
Route::any('/qnaireToDoAjax',"QnaireController@qnaireToDoAjax");
Route::any('/deployedQnaireListAjax',"QnaireController@deployedQnaireListAjax");

Route::any('/draftDone',"DraftController@draftDone");
Route::any('/draftSaveAjax',"DraftController@draftSaveAjax");
Route::any('/draftReadAjax',"DraftController@draftReadAjax");

Route::any('/test', function () {
	return view("test");
});
Route::any('/returntest', function () {
	$data=[1,2];
	$bool=var_dump(array_search(3, $data));
	if(!is_bool(0))
		echo "hello";
});