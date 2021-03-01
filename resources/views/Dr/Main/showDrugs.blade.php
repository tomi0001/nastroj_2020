@php
    $z = 0;
@endphp
    @foreach ($listDrugs as $list) 
    <div class="empty"></div>
    <div class='show_drugs' id='titleDrugs{{$z}}'>
        <div class='titleDrugs' >
            
            {{$z+1}}
        </div>
        <div id="EditDrugs{{$z}}">
        <table class='table center' style="width: 85%; margin-left: auto;margin-right: auto;">
            <tr>
                <td class="centerDrugs">
                    Nazwa produktu
                </td>
                <td class="centerDrugs">
                    {{$list->name}}
                    
                </td>
            </tr>
             <tr>
                <td class="centerDrugs">
                    Dawka produktu
                </td>
                <td class="centerDrugs">
                    {{$list->portion}} 
                    @switch ($list->type)
                    @case ($list->type == 1) mg
                    @break
                    @case ($list->type == 2) mililtry
                    @break
                    @default ilości
                    @endswitch
                </td>
            </tr>
             <tr>
                <td class="centerDrugs">
                    Data wzięcia
                </td>
                <td class="centerDrugs">
                    {{$list->date}} 

                </td>
            </tr>
             <tr>
                <td class="centerDrugs">
                    Wydałeś na to
                </td>
                <td class="centerDrugs">
                    {{$list->price}} 

                </td>
            </tr>
            @if ($list->percent != 0)
             <tr>
                <td class="center_danger">
                    Ilośc wypitego alkoholu
                </td>
                <td class="center_danger">
                    {{$list->percent}} 
                    @switch ($list->type)
                    @case ($list->type == 1)
                        Mg
                    @break
                    @case ($list->type == 2)
                        Militry
                    @break
                    @default
                        ilości
                    @endswitch
                    

                </td>
            </tr>
            @endif
            @if ($equivalent[$z] != 0)
             <tr>
                <td class="center_danger" id='equivalent_tr_{{$z}}'>
                    Równoważnik diazepamu
                </td>
                <td class="center_danger">
                    <div id="equivalent_{{$z}}">{{$equivalent[$z]}}
                    @switch ($list->type)
                        @case ($list->type == 1)
                        Mg
                        @break
                        @case ($list->type == 2)
                        Militry
                        @break
                        @default
                        ilości
                    
                    
                    @endswitch
                    </div>
                </td>
            </tr>
            <tr>
                <td class="centerDrugs">
                    Przelicz na inną benzodiazepinę
                </td>
                <td class="centerDrugs">
                    <form method='get' id='changebenzo{{$z}}}'>
                        <select name='benzo{{$z}}' class='form-control form-control-lg'>
                            @foreach ($benzo as $ben)
                            <option value='{{$ben->id}}'>{{$ben->name}}</option>
                            @endforeach
                        </select>
                        
                    
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <div class='center'> <input type='button' class='btn btn-success' onclick="calculateBenzo('{{ route('DrDrugs.calculateBenzo')}}',{{$z}} ,{{$equivalent[$z]}})" value='Oblicz równoważnik'></div>
                </td>
                
            </tr>
         
                    
              
           
            </form>
            @endif    
           
        </table>
        </div>
        <div id='sumbenzo{{$z}}' class='center'></div>
        <table class="table center" style="width: 85%; margin-left: auto;margin-right: auto;" >
          
            <tr>
                <td class="centerDrugs">
                    
                    
                    @if ($ifDescription[$z] == true)
                    <input type="button" class="btn btn-success btn-lg" onclick="showDescriptionDrugs({{$z}},'{{route('DrDrugs.showDescription')}}',{{$list->idDrugs}})" value="Pokaż opis">
                    @else
                    <input type="button" class="btn btn-danger btn-lg" onclick="show_description()" value="Nie było opisu" disabled>
                    @endif
                </td>
                <td class="centerDrugs">
                    <input type="button" class="btn btn-success btn-lg" onclick="sum_average('{{route('DrDrugs.sumAverage')}}',{{$list->idDrugs}},{{$z}})" value="Oblicz średnią">
                </td>

            </tr>

             <tr>
                <td class="centerDrugs" colspan="2">
                    <div id="viewDrugs{{$z}}">
                        
                    </div>
                </td>
            </tr>
            
            
            
           

                   
            
 
            
            
        </table>
        
         <div  class="sumAverage" id='sum_average{{$z}}' style="overflow-y: scroll;  height:300; display: none;"></div>
         <div  class="sumAverage" id='show_descriptionDrugs{{$z}}' style="overflow-y: scroll;  height:300; display: none;"></div>
    </div>
    @if ($separate[$z]["bool"] == true)
        <br><br><br>
    @else
    <br>
    @endif
    
        @php
            $z++;
        @endphp
        
    @endforeach
    
