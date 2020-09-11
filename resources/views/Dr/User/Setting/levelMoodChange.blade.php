<div id='levelMood' style='display: none;'>
        <form method='get'>
            <table class='table'>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli samobójcze i totalną depresję
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-10From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[0]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-10To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[0]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli samobójcze i totalną depresję, ale trochę mniejsze
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-9From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[1]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-9To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[1]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i totalną depresję 
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-8From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[2]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-8To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[2]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i totalną depresję, ale trochę mniejsze
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-7From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[3]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-7To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[3]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i totalną depresję
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-6From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[4]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-6To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[4]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i umiarkowną depresję
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-5From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[5]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-5To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[5]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli lekką depresję
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-4From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[6]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-4To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[6]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz lekkie obniżenie nastroju
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-3From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[7]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-3To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[7]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli chandre
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-2From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[8]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-2To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[8]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli lzejszą handrę
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-1From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[9]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-1To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[9]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz się normalnie
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood0From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[10]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood0To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[10]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz się trochę lepiej
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood1From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[11]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood1To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[11]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz nastrój lekko podwyższony
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood2From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[12]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood2To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[12]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz nastrój jeszcze bardziej podwyższony
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood3From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[13]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood3To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[13]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz lekką hipomanię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood4From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[14]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood4To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[14]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz hipomanię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood5From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[15]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood5To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"   value="{{$levelMood[15]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz większą hipomanię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood6From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[16]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood6To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[16]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz lekką manię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood7From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[17]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood7To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[17]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz manię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood8From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[18]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood8To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[18]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz silniejszą manię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood9From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[19]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood9To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[19]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz, że masz bardzo silną manię
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood10From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"  value="{{$levelMood[20]["from"]}}"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood10To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')" value="{{$levelMood[20]["to"]}}">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                <TR>
                 
                    <td colspan='2' class='center'>
                        <input type='button' onclick="SettingchangeLevelMood('{{ route('Setting.levelMoodChange')}}')" class='btn btn-primary' value='Dodaj Akcje'>
                    </td>
                    
                </TR>
                <TR>
                 
                    <td colspan='2' class='center' id="form1">
                     
                    </td>
                    
                </TR>
            </table>
        </form>
    </div>