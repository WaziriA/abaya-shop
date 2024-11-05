@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">List of All Subscribers</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Subscribers</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Users</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="row justify-content-between d-flex">
                          <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#AddSubscriberModel">Add</button>
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                        
                                    
                                    <tr>
                                        <td>{{$subscriber->name}}</td>
                                        <td>{{$subscriber->email}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin/users/subscriber/add-modal')