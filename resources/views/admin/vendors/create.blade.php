@extends('layouts.admin')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.vendors')}}"> المتاجر </a>
                            </li>
                            <li class="breadcrumb-item active">إضافه متجر جديد
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form"> إضافه متجر جديد </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            @include('admin.includes.alerts.success')
                            @include('admin.includes.alerts.errors')
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form" action="{{route('admin.vendors.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1"> لوجو المتجر </label>
                                                <input type="file" value="" id="file" class="form-control" placeholder="" name="logo">
                                                <span class="file-custom"></span>
                                                @error('logo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-home"></i> بيانات المتجر </h4>


                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> الأسم</label>
                                                        <input type="text" id="name" class="form-control" placeholder="" name="name">
                                                        @error("name")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label for="project1">أختر القسم</label>
                                                        <select name="category_id" class="select2 form-control">
                                                        <optgroup label="من فضلك اختر القسم">
                                                        @if($categories && $categories->count() > 0)
                                                        @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category -> name }}</option>
                                                        @endforeach
                                                        @endif
                                                        </optgroup>
                                                        </select>
                                                        @error("name")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                
                                            </div>

                                            <div class="row">

                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">رقم الهاتف</label>
                                                        <input type="text" id="mobile" class="form-control" placeholder="" name="mobile">
                                                        @error("mobile")
                                                        <span class="text-danger">{{$message}} </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">البريد الألكتروني</label>
                                                        <input type="text" id="email" class="form-control" placeholder="" name="email">
                                                        @error("email")
                                                        <span class="text-danger">{{$message}} </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox" value="1" name="active" id="switcheryColor4" class="switchery" data-color="success" checked />
                                                        <label for="switcheryColor4" class="card-title ml-1">الحاله</label>

                                                        @error("active")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="button" class="btn btn-warning mr-1" onclick="history.back();">
                                                <i class="ft-x"></i> تراجع
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> حفظ
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic form layout section end -->
        </div>
    </div>
</div>
@endsection