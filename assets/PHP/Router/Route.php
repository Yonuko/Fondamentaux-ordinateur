<?php

/**
 * Route Site
 */
$router->get('portfolio', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/accueil.php");
});

$router->get('portfolio/blog', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/blog.php");
});

$router->get('portfolio/skills', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/skills.php");
});

$router->get('portfolio/projects', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/projects.php");
});

$router->get('portfolio/contact', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/contact.php");
});

$router->get('portfolio/projects/{id}/{test}/{coucou}', function ($id, $ids, $test) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/project.php");
});

$router->get('portfolio/projects/{id}', function ($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/project.php");
});

$router->get('portfolio/post/{id}', function ($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/post.php");
});

/**
 *  Route Admin
 */
$router->get('portfolio/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/login.php");
});

$router->post('portfolio/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/Connexion.php");
});

$router->post('portfolio/logout', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/logout.php");
  header("location:http://localhost/portfolio/");
});

$router->get('portfolio/admin', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/admin.php");
});

$router->get('portfolio/admin/blog', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog/blog.php");
});

$router->get('portfolio/admin/blog/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog/PostCreate.php");
});

$router->post('portfolio/admin/blog/store', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/blog/store.php");
});

$router->get('portfolio/admin/blog/{id}', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog/PostEdit.php");
});

$router->post('portfolio/admin/blog/{id}/update', function ($request, $id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/blog/update.php");
});

$router->get('portfolio/admin/blog/{id}/active', function ($id){
  needAdmin();
  $rqt = "SELECT isShown FROM posts WHERE post_id = ?;";
  $isActive = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  $rqt = "UPDATE posts SET isShown = ? WHERE post_id = ?;";
  sendRequest($rqt, [!$isActive, $id], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/blog");
});

$router->get('portfolio/admin/blog/{id}/delete', function ($id){
  needAdmin();
  $rqt = "SELECT logo FROM posts WHERE post_id = ?;";
  $filename = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  unlink($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/image/Uploads/Blog/" . $filename);
  $rqt = "DELETE FROM posts WHERE post_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  $rqt = "DELETE FROM post_descriptions WHERE post_id = ?";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/blog");
});

$router->get('portfolio/admin/texte', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Texte.php");
});

$router->post('portfolio/admin/texte', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/TextUpdate.php");
});

$router->get('portfolio/admin/skills', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/skills/Competences.php");
});

$router->get('portfolio/admin/skills/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/skills/SkillCreate.php");
});

$router->post('portfolio/admin/skills/store', function ($request){
  needAdmin();
  $data = $request->getBody();
  $rqt = "INSERT skills VALUES (null, ?, ?, ?, 1, 0);";
  sendRequest($rqt, [$data["name"], $data["value"], $data["type"]], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/skills");
});

$router->post('portfolio/admin/skills/update', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/skills/update.php");
});

$router->get('portfolio/admin/skills/{id}/delete', function ($id){
  needAdmin();
  $rqt = "DELETE FROM skills WHERE skill_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/skills");
});

$router->get('portfolio/admin/projects', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Projets/Projets.php");
});

$router->get('portfolio/admin/projects/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Projets/ProjectCreate.php");
});

$router->post('portfolio/admin/projects/store', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/projects/store.php");
});

$router->post('portfolio/admin/projects/{id}/update', function ($request, $id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/projects/update.php");
});

$router->get('portfolio/admin/projects/{id}', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Projets/ProjetEdit.php");
});

$router->get('portfolio/admin/projects/{id}/active', function ($id){
  needAdmin();
  $rqt = "SELECT isShown FROM projects WHERE project_id = ?;";
  $isActive = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  $rqt = "UPDATE projects SET isShown = ? WHERE project_id = ?;";
  sendRequest($rqt, [!$isActive, $id], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/projects");
});

$router->get('portfolio/admin/projects/{id}/delete', function ($id){
  needAdmin();
  $rqt = "SELECT logo FROM projects WHERE project_id = ?;";
  $filename = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  unlink($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/image/Uploads/Projets/" . $filename);
  $rqt = "DELETE FROM projects WHERE project_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  $rqt = "DELETE FROM project_types WHERE project_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  $rqt = "DELETE FROM projects_description WHERE project_id = ?";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/projects");
});

$router->get('portfolio/admin/CV', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/CV.php");
});