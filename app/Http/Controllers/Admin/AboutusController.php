<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Models\Aboutus;
use Validator;
use Session;
use Config;
class AboutusController extends Controller
{
    public function __construct(Aboutus $Aboutus)
    {
        $data               = [];
        $this->title        = "About Us";
        $this->url_slug     = "aboutus";
        $this->folder_path  = "admin/aboutus/";
    }
    public function index(Request $request)
    {
        $aboutus = Aboutus::get();

        $data['data']      = $aboutus;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
    public function add()
    {
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            // 'link'         => 'required',
            'title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $aboutus = new Aboutus();
        $arr_data               = [];
        $aboutus->title = $request->title;
        $aboutus->short_description = $request->short_description;
        $aboutus->long_description = $request->long_description;
        $status = $aboutus->save();
        $last_id = $aboutus->id;
        $path = Config::get('DocumentConstant.ABOUTUS_ADD');

        if ($request->hasFile('image')) {

            if ($aboutus->image) {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.ABOUTUS_DELETE') . $aboutus->image);
                if(file_exists($delete_file_eng)){
                    unlink($delete_file_eng);
                }

            }

            $fileName = $last_id.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
           
            $brand = Aboutus::find($last_id);
            $brand->image = 'No Image';
            $brand->save();
        }
        if (!empty($brand))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_aboutus');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function edit($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Aboutus::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $short_description = $request->short_description;
        $long_description = $request->long_description;
        
        $arr_data               = [];
        $aboutus = Aboutus::find($id);
        $existingRecord = Aboutus::orderBy('id','DESC')->first();
        $aboutus->title = $request->title;
        $aboutus->short_description = $request->short_description;
        $aboutus->long_description = $request->long_description;
        $status = $aboutus->update();    
        $path = Config::get('DocumentConstant.ABOUTUS_ADD');

        if ($request->hasFile('image')) {

            if ($aboutus->image) {
                $delete_file_eng= storage_path(Config::get('DocumentConstant.ABOUTUS_DELETE') . $aboutus->image);
                if(file_exists($delete_file_eng)){
                    unlink($delete_file_eng);
                }

            }
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
            
                for ($i = 0; $i < 10; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
            $fileName = $randomString.".". $request->image->extension();
            uploadImage($request, 'image', $path, $fileName);
           
            $brand = Aboutus::find($id);
            $brand->image = 'No Image';
            $brand->save();   
        } 
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_aboutus');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function delete($id)
    {
        $id = base64_decode($id);
        $all_data=[];
        $certificate = Aboutus::find($id);
        $certificate->delete();
        return \Redirect::to('manage_aboutus');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $arr_data = [];
        $data1     = Aboutus::find($id);
        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

   
}