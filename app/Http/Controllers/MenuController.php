<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class MenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $catFlow = flowRepo::getFlowGroupCat();
        if(Session::has('UserLogin')){
            $id = Session::get('UserLogin')->user_Id;
            $data = userRepo::getUser($id);
            if($data!=null){
                return view('Home',['data'=>$data,'catFlow'=>$catFlow]);
            }
        } else if($request->has('username')) {
            $ldap = ldap_connect("13.229.128.241",389);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $searchOnLdap=ldap_search($ldap, "dc=ldap,dc=doculdap,dc=tk", "mail=".$request->input('username'));
            $userOnLdap = ldap_get_entries($ldap, $searchOnLdap);
            if($userOnLdap['count']==0){
                return view('Login')->with("Err","Don't have this E-mail on our organization, Please contact the administrator.");
            }
            if($userOnLdap[0]['userpassword'][0] == hash("sha256",$request->input('password'))){
                $data = userRepo::getUser($userOnLdap[0]['uid'][0]);
                if($data!=null){
                    Session::put('UserLogin',$data);
                    return view('Home',['data'=>$data,'catFlow'=>$catFlow]);
                } else {
                    return view('Login')->with("Err","Don't have user in database, Please contact the administrator.");
                }
            } else {
                return view('Login')->with("Err","Password incorrect, Please try agian.");
            }
        } else {
            return view('Login')->with("Err","");
        }
        return ;
    }
}
