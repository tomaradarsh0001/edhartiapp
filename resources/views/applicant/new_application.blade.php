@extends('layouts.app')

@section('title', 'Applicant Property History')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">New Applications</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Application</li>
                    <li class="breadcrumb-item active" aria-current="page">New Application</li>
                
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
        <h5 id="title1">Select Status of Property</h5>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="radio-buttons-0">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label for="existingProperty" class="custom-radio">
                                        <div class="radio-btn">
                                            <div class="content">
                                                <div class="profile-card">
                                                    <h4>Services in existing property</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="radio" name="purposeReg" value="existing_property"
                                            id="existingProperty" class="radio_input_0">
                                    </label>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="allotment" class="custom-radio">
                                        <div class="radio-btn">
                                            <div class="content">
                                                <div class="profile-card">
                                                    <h4>Allotment of New Property</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="radio" name="purposeReg" value="allotment" id="allotment"
                                            class="radio_input_0">
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="radio-buttons" style="display: none;">
                            <!-- <div class="d-block text-start">
                                <a href="javascript:void(0);" class="btn btn-dark backButton0"><i class="lni lni-arrow-left"></i></a>
                            </div> -->
                            <h5>Registration As</h5>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label for="propertyowner" class="custom-radio">
                                        <div class="radio-btn">
                                            <div class="content">
                                                <div class="profile-card">
                                                    <h4>Individual Owner/Lessee/Allottee</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="radio" name="newUser" value="propertyowner" id="propertyowner"
                                            class="radio_input">
                                    </label>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="organization" class="custom-radio">
                                        <div class="radio-btn">
                                            <div class="content">
                                                <div class="profile-card">
                                                    <h4>Organization Owner/Lessee/Allottee</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="radio" name="newUser" value="organization" id="organization"
                                            class="radio_input">
                                    </label>
                                </div>
                            </div>
                        </div>
                     
                    </form>
        </div>
    </div>

    {{-- Dynamic Element --}}
@endsection
@section('footerScript')
    
@endsection
