<?php
namespace App\Repositoryinterface\Profiles\GuestProfile;

interface RepositoryGuestInhouseInterface{
    public function index();
    public function inhousPagination();
     public function store($request);
       public function show($id);
       public function update($request, $id);


       //public function updateStatus($request, $id);

       public function availability($reuest);

       public function reservisionUpdate($request,$id);
       public function isGroupUpdate($request,$id);
       public function isDummy($request,$id);
       public function IsPM($request,$id);
       public function isCancel($id);
       public function isCheckedIn($id);
       public function reInstate($id);







     //  public function updateIsReservation($request, $id);
    //  public function destroy($id);
    //  public function geSoftDeletedData();
    //  public function restorDataTrashed($id);
}
