<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Http\Request;
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



        //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:projects,title',
            'desc' => 'required',
            'leader' => 'required',
            'members' => 'required',
            'start_date' => 'required',
            'deadline' => 'required',
            'priority' => 'required',

        ])->validate();
    }
}
