<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    //get project list
    public function getProjectList(){
        $projects = Project::get();
        $projectMembers = [];
        foreach($projects as $project){
            $member = ProjectMember::select('project_members.*', 'users.img as img')
                                ->where('project_id', $project->id)
                                ->leftJoin('users','users.id', 'project_members.user_id')
                                ->get();
            array_push($projectMembers, $member);
        }

        return response()->json([
            'projects' => $projects,
            'projectMembers' => $projectMembers,
            'status' => true
        ]);

    }
    //create project
    public function createProject(Request $request){
        $this->Validation($request);

        //image and file handle
        if($request->file('images')){
            $images = [];
            foreach($request->file('images') as $img){
                $imgName = uniqid() . '_' . $img->getClientOriginalName();
                $img->move(public_path('project/images'), $imgName);
                array_push($images, $imgName);
            }
        }else{
                $images = [];
        }

        if($request->file('files')){
            $files = [];
            foreach($request->file('files') as $file){
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('project/files'), $fileName);
                array_push($files, $fileName);
            }
        }else{
                $files = [];
        }

        $data = [
            'title' => $request->title,
            'description' => $request->desc,
            'images' => json_encode($images),
            'files' => json_encode($files),
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
        ];

        $project = Project::create($data);

        ProjectMember::firstOrCreate([
            'project_id' =>$project->id,
            'user_id' => $request->leader,
            'role' => 'leader'
        ]);

        foreach(($request->members ?? []) as $member){
            ProjectMember::firstOrCreate([
            'project_id' =>$project->id,
            'user_id' => $member,
            'role' => 'member'
        ]);
        }

        return response()->json([
            'message' => 'Project successfully created!',
            'status' => true
        ]);

    }

    //get update data
    public function getProjectData($id){
        $project = Project::where('id', $id)->first();
        $projectMembers = ProjectMember::where('project_id', $id)->get();

        return response()->json([
            'project' => $project,
            'pjMembers' => $projectMembers
        ]);
    }

    //update project
    public function updateProject(Request $request){
        $this->updateVal($request);

        $projects = Project::where('id', $request->id)->first();

         //image and file handle
        $images = json_decode($projects->images);

        if($request->file('images')){
            foreach($request->file('images') as $img){
                $imgName = uniqid() . '_' . $img->getClientOriginalName();
                $img->move(public_path('project/images'), $imgName);
                array_push($images, $imgName);
            }
        }

         $files = json_decode($projects->files);
        if($request->file('files')){
            foreach($request->file('files') as $file){
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('project/files'), $fileName);
                array_push($files, $fileName);
            }
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'images' =>  json_encode($images),
            'files' => json_encode($files),
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status,
        ];

        Project::where('id', $request->id)->update($data);

        $oldPjLeader = ProjectMember::where('project_id', $request->id)->where('role', 'leader')->first();
        $pjleader = [
            'project_id' =>$request->id,
            'user_id' => $request->leader,
            'role' => 'leader'
        ];

        if($request->leader !== $oldPjLeader->user_id){
            ProjectMember::where('project_id', $request->id)->where('role', 'leader')->update($pjleader);
        }

        foreach(($request->members ?? []) as $member){
            ProjectMember::firstOrCreate([
            'project_id' =>$request->id,
            'user_id' => $member,
            'role' => 'member'
        ]);
        }

        return response()->json([
            'message' => 'Project successfully updated!',
            'status' => true
        ]);
    }

    //delete project
    public function deleteProject($id){
        $dbData = Project::where('id', $id)->first();
        $dbimages = json_decode($dbData->images);
        $dbfiles = json_decode($dbData->files);

        Project::where('id', $id)->delete();
        ProjectMember::where('project_id', $id)->delete();

        foreach($dbimages as $img){
            if(File::exists(public_path() . '/project/images/' . $img)){
                File::delete(public_path() . '/project/images/' . $img);
            }
        }

        foreach($dbfiles as $file){
            if(File::exists(public_path() . '/project/files/' . $file)){
                File::delete(public_path() . '/project/files/' . $file);
            }
        }

        $message = 'Project deleted successfully!';
        return response()->json($message);
    }
    //delete project member
    public function deleteProjectMember($id){
        ProjectMember::where('id', $id)->delete();
        $message = 'Member remove successfully!';
        return response()->json($message);
    }
    //delete project item
    public function deleteProjectItem($id , $itemName, $type){
        $dbData = Project::where('id', $id)->first();
        $dbimages = json_decode($dbData->images);
        $dbfiles = json_decode($dbData->files);

        if($type == 'file'){
            //remove from database
            $key = array_search($itemName, $dbfiles);
                if ($key !== false) {
                    unset($dbfiles[$key]);
                    $dbData->update(['files' => json_encode($dbfiles)]);
            }

            if(File::exists(public_path() . '/project/files/' . $itemName)){
                File::delete(public_path() . '/project/files/' . $itemName);
            }

        }else{
            //remove from database
            $key = array_search($itemName, $dbimages);
                if ($key !== false) {
                    unset($dbimages[$key]);
                     $dbData->update(['images' => json_encode($dbimages)]);
            }
            if(File::exists(public_path() . '/project/images/' . $itemName)){
                File::delete(public_path() . '/project/images/' . $itemName);
            }
        }

        $message = $type . ' delete successfully!';
        return response()->json($message);
    }

    //show project detail
    public function getProjectDetail($id){
         $project = Project::where('id', $id)->first();

            $teamMembers = ProjectMember::select('project_members.*', 'users.img as img' , 'users.name as name')
                                ->where('project_id', $project->id)
                                ->leftJoin('users','users.id', 'project_members.user_id')
                                ->get();


        return response()->json([
            'project' => $project,
            'teamMembers' => $teamMembers,
            'status' => true
        ]);
    }

    //get auth user's project
    public function getmyPorjects($id){
        $projects = ProjectMember::where('user_id', $id)->get();
        $projectList = [];
        foreach($projects as $project){
            $pjItem = Project::where('id', $project->project_id)->first();

            array_push($projectList, $pjItem);
        }

        $projectMembers = [];
        foreach($projectList as $project){
            $member = ProjectMember::select('project_members.*', 'users.img as img')
                                ->where('project_id', $project->id)
                                ->leftJoin('users','users.id', 'project_members.user_id')
                                ->get();
            array_push($projectMembers, $member);
        }
        return response()->json(['projects' => $projectList, 'projectMembers' => $projectMembers]);
    }

    //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:projects,title' ,
            'desc' => 'required',
            'leader' => 'required',
            'members' => 'required',
            'start_date' => 'required',
            'deadline' => 'required',
            'priority' => 'required',

        ])->validate();
    }

    //validate
    private function updateVal($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:projects,title,' . $request->id,
            'description' => 'required',
            'leader' => 'required',
            'members' => 'required',
            'start_date' => 'required',
            'deadline' => 'required',
            'priority' => 'required',

        ])->validate();
    }
}
