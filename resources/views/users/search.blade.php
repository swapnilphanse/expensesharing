@extends('layouts.app', ['pageSlug' => 'addusers'])

@section('content')
<!-- Swapnil Phanse -->
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add User') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" required>
                                    @include('alerts.feedback', ['field' => 'phone'])
                                </div>

                               
                            </div>


                           
      <div class="card-header">
     
        <h4 class="card-title"> User Details</h4>
      </div>
      <div class="card-body">
      @include('alerts.success')
        <div class="table-responsive">
       <form method="post" action ="/adduser">
       <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
          <table class="table tablesorter " id="">
          <thead class=" text-primary">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Add</th>
            </tr>
       
            </thead>

            <tbody>
          
           
            </tbody>
          </table>

        </form>

        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
<script >
        $.ajaxSetup({ headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')} });
        </script>
        
        <script>
            $('#input-phone').on('keyup',function(){
            $value=$(this).val();
            $.ajax({
                type : 'get',
                url : '{{URL::to('search')}}',
                data:{'search':$value},
                success:function(data){
                $('tbody').html(data);
                }
            });
        });
        </script>


@endpush