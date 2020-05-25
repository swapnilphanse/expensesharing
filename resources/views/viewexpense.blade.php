@extends('layouts.app',['page' => __('View Expense'), 'pageSlug' => 'viewaddexpense'])

@section('content')
   

<div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Expense Details') }}</h4>
                        </div>
                       
                    </div>
                </div>

                
                <div class="card-body">
                    @include('alerts.success')

                    @foreach ($data as $exp)
                                @if($loop->first)
                                <h1 class="card-title" style="text-align:center" >{{ strtoupper($exp -> ename) }}</h1>
                                @endif
                                @endforeach          
                    <h1 class="card-title"> </h1>
                    <form method="post" action="#">
                   
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Paid By') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                               
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                              
                            @foreach ($data as $exp)
                                    <tr>
                                        <td> {{ $exp->name }} </td>
                                        @if( $exp->paid_by  == 0)

                                        <input type="hidden" name="name" value="{{ $exp->id }}"> 
                                        <td> Owes </td>
                                        @else
                                        <input type="hidden" name="name" value="{{ $exp->id }}"> 
                                        <td> Paid the total amount </td>
                                        @endif
                                        <td>${{ number_format($exp->iamount,2) }} </td>
                                       
                                    </tr>
                                    @if($loop->first)
                                    
                                    @endif

                                @endforeach
                            </tbody>
                        </table>
                      
                    </div>
                                @foreach ($data as $exp)
                                @if($loop->first)
                                <p style="text-align:center;font-size:20px"> The total amount of this expense is $<b>{{ $exp->amount }}.</b> </p>
                                @endif
                                @if($exp -> paid_by == 0)
                                <p style="text-align:center;font-size:20px"> {{ $exp->name }} owes ${{ number_format($exp->iamount,2) }}. </p>@endif
                                @if($exp -> paid_by == 1) 
                                <p style="text-align:center;font-size:20px" >{{ $exp->name }} paid the whole amount.</p> @endif  
                               
                                @endforeach 


                                <?php
                $id = Auth::user()->id;
               ?> 
               
               @foreach($data as $exp)
               @if($loop->first)
              @if($id != $exp->added_by  )
              <button type="submit"   class="btn btn-success mt-4" style="margin:0px auto;display:block;text-align:center">{{ __('Settle Payment') }}</button>
              @endif
                  @endif
              @endforeach 
              </form>
                </div>

          
                  

              
            </div>
        </div>
    </div>
    @endsection