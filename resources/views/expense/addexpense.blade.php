@extends('layouts.app', ['page' => __('Add Expense'), 'pageSlug' => 'addexpense'])

@section('content')
<!-- Swapnil Phanse -->

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add Expense') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    @include('alerts.success')
                        <form method="post" action="{{route('addexpense.store')}}" autocomplete="off">
                            @csrf
                            
                         <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Add name') }}</label>
                                    <select name="name[]" id="input-name" multiple class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" data-size="7" data-style="btn btn-primary"  tabindex="-98"></select>   
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>

                                <div class="form-group {{ $errors->has('category') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                      
                                    <select class="form-control form-control-alternative{{ $errors->has('category') ? ' is-invalid' : '' }}"  name="category">
                    
                                    <option class="bs-title-option" value=""> Select one option</option>
                                    <option value="Miscellaneous">Miscellaneous</option> 
                                    <option value="Food">Food</option> 
                                    <option value="Outing">Outing</option> 
                                    <option value="Cab">Cab</option> 
                                    <option value="Fees">Fees</option> 
                                    <option value="MobileBill">Mobile Bill</option> 
                                    <option value="Rent">Rent</option> 
                                    <option value="Groceries">Groceries</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'split'])
                                  </div>


                                <div class="form-group{{ $errors->has('ename') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-ename">{{ __('Expense Name') }}</label>
                                    <input type="test" name="ename" id="input-ename" class="form-control form-control-alternative{{ $errors->has('ename') ? ' is-invalid' : '' }}" placeholder="{{ __('Expense Name') }}">
                                    @include('alerts.feedback', ['field' => 'ename'])
                                </div>

                                <div class="form-group {{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-amount">{{ __('Amount') }}</label>
                                    <input type="number" name="amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="{{ __('$0.00') }}">
                                    @include('alerts.feedback', ['field' => 'amount'])
                                </div>
                               
                    <div class="form-group {{ $errors->has('split') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-split">{{ __('Split') }}</label>
                      
                    <select class="form-control form-control-alternative{{ $errors->has('split') ? ' is-invalid' : '' }}"  name="split">
                    
                    <option class="bs-title-option" value=""> Select one option</option>
                      <option value="50%">Split Equally</option> 
                    </select>
                    @include('alerts.feedback', ['field' => 'split'])
                    </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script>

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#input-name" ).select2({
    placeholder: "Select Names..",
    minimumInputLength: 1,
    ajax: { 
      url: "{{route('autocomplete')}}",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          _token: CSRF_TOKEN,
          search: params.term 
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }

  });

});
</script>

@endpush