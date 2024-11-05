@extends('admin.layout')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">List of All Orders</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Offline Orders</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Orders</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="row justify-content-between d-flex">
                          <button type="button" class="btn btn-primary mb-4 waves-effect btn-sm" data-toggle="modal" data-target="#AddModalCenter">Add</button>
                          <button type="button" class="btn btn-success mb-4 waves-effect btn-sm text-white">Export</button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Product Name</th>
                                        <th>Customer Name</th>
                                        <th>Quantity</th>
                                        <th>Phone No</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Place</th>
                                        <th>Shipping Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>27</td>
                                        <td><span class="badge badge-success badge-pill text-white">Complete</span></td>
                                        <td>$320,800</td>
                                        <td>2011/04/25</td>
                                        <td>$112,000</td>
                                        
                                        <td>
                                            <div class="d-flex justify-content-between">
                                              <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#EditModalCenter"></button>
                                              <button class="btn btn-danger fa fa-trash text-white"></button>
                                            </div>
                                        </td>
                                    </tr>
                                   
                                   
                                    <tr>
                                        <td>Donna Snider</td>
                                        <td>Customer Support</td>
                                        <td>New York</td>
                                        <td>27</td>
                                        <td>27</td>
                                        <td><span class="badge badge-warning badge-pill text-white">pending</span></td>
                                        <td>$112,000</td>
                                        <td>2011/04/25</td>
                                        <td>$112,000</td>
                                        
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-success fa fa-edit text-white" data-toggle="modal" data-target="#EditModalCenter"></button>
                                                <button class="btn btn-danger fa fa-trash text-white"></button>
                                              </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Product Name</th>
                                        <th>Customer Name</th>
                                        <th>Quantity</th>
                                        <th>Phone No</th>
                                        <th>Payment Status</th>
                                        <th>Payment ID</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Place</th>
                                        <th>Shipping Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin/offline-order/add-modal')
@include('admin/offline-order/edit-modal')
@endsection