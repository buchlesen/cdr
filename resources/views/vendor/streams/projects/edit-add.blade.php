@extends('streams::master')

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="{{ config('streams.assets_path') }}/lib/js/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.min.css" >
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ 'Edit' }}@else{{ 'New' }}@endif {{ $dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form data-parsley-validate role="form" action="@if(isset($dataTypeContent->id)){{ route('streams.projects.update', $dataTypeContent->id) }}@else{{ route('streams.projects.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <!--<i class="streams-character"></i>--> Partner
                                {{--<span class="panel-desc"> Partner Name</span>--}}
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="partner">Partner Name</label>
                                <input type="text" class="form-control" id="partner" name="partner" placeholder="" value="@if(isset($dataTypeContent->partner)){{ $dataTypeContent->partner }}@endif" data-parsley-required>
                            </div>
                            <div class="form-group">
                                <label for="accountManagerName">Name of Account Manager handling this opportunity</label>
                                <input type="text" class="form-control" id="accountManagerName" name="accountManagerName" placeholder="" value="@if(isset($dataTypeContent->account_manager_name)){{ $dataTypeContent->account_manager_name }}@endif" data-parsley-required>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <!--<i class="streams-character"></i>--> Customer Info
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="companyName">Official Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="companyName" placeholder="" value="@if(isset($dataTypeContent->company_name)){{ $dataTypeContent->company_name }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="customerIndustryId">Customer Industry</label>
                                <select class="form-control" id="customerIndustryId" name="customerIndustryId" data-parsley-required>
                                    <option value=""></option>
                                    @foreach(App\Components\DealRegistration\Models\CustomerIndustry::all() as $customerIndustry)
                                        {{--<option value="{{ $customerIndustry->id }}" @if(isset($dataTypeContent->customer_info_id) && $dataTypeContent->customer_info_id == $customerIndustry->id){{ 'selected="selected"' }}@endif>{{ $customerIndustry->name }}</option>--}}
                                        <option value="{{ $customerIndustry->id }}" @if(isset($dataTypeContent->customer_info_id) && App\Components\DealRegistration\Models\CustomerInfo::find($dataTypeContent->customer_info_id)->customerIndustry->id == $customerIndustry->id){{ 'selected="selected"' }}@endif>{{ $customerIndustry->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="hqAddress">HQ Address</label>
                                <input type="text" class="form-control" id="hqAddress" name="hqAddress" placeholder="" value="@if(isset($dataTypeContent->hq_address)){{ $dataTypeContent->hq_address }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="branchAddress">Branch Address</label>
                                <input type="text" class="form-control" id="branchAddress" name="branchAddress[]" placeholder="" value="@if(isset($dataTypeContent->branch_address)){{ $dataTypeContent->branch_address }}@endif">
                            </div>

                            <button type="button" id="addBranchAddress" class="btn btn-primary pull-right">
                                @if(isset($dataTypeContent->id)){{ 'More branch address' }}@else<?= '<i class="icon wb-plus-circle"></i> More branch address'; ?>@endif
                            </button>

                            <div class="form-group">
                                <label for="ownership">Ownership (main shareholder)</label>
                                <input type="text" class="form-control" id="ownership" name="ownership" placeholder="" value="@if(isset($dataTypeContent->ownership)){{ $dataTypeContent->ownership }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="siteNumber">Number of Sites</label>
                                <input type="text" class="form-control" id="siteNumber" name="siteNumber" placeholder="" value="@if(isset($dataTypeContent->site_number)){{ $dataTypeContent->site_number }}@endif" data-parsley-type="number">
                            </div>

                            <div class="form-group">
                                <label for="officeNumber">Number of Offices</label>
                                <input type="text" class="form-control" id="officeNumber" name="officeNumber" placeholder="" value="@if(isset($dataTypeContent->office_number)){{ $dataTypeContent->office_number }}@endif" data-parsley-type="number">
                            </div>

                            <div class="form-group">
                                <label for="branchNumber">Number of Branches</label>
                                <input type="text" class="form-control" id="branchNumber" name="branchNumber" placeholder="" value="@if(isset($dataTypeContent->branch_number)){{ $dataTypeContent->branch_number }}@endif" data-parsley-type="number">
                            </div>

                            <div class="form-group">
                                <label for="totalEmployee">Total number of employee</label>
                                <input type="text" class="form-control" id="totalEmployee" name="totalEmployee" placeholder="" value="@if(isset($dataTypeContent->total_employee)){{ $dataTypeContent->total_employee }}@endif" data-parsley-type="number">
                            </div>
                        </div>
                    </div>

                    <div class="panel" id="account-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <!--<i class="streams-character"></i>--> Account Info
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="employeeConnectToWifi">How many employee that connect to corporate WiFi?</label>
                                <input type="text" class="form-control" id="employeeConnectToWifi" name="employeeConnectToWifi" placeholder="" value="@if(isset($dataTypeContent->employee_connect_to_wifi)){{ $dataTypeContent->employee_connect_to_wifi }}@endif" data-parsley-required data-parsley-type="number">
                            </div>
                            <div class="form-group">
                                <label for="multipleIsp">Do they use multiple ISPs</label>
                                <textarea class="form-control" id="multipleIsp" name="multipleIsp" >
                                    @if(isset($dataTypeContent->multiple_isp)){{ $dataTypeContent->multiple_isp }}@endif
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="ispListAndBandwidth">List the ISP used and their Bandwidth</label>
                                <textarea class="form-control" id="ispListAndBandwidth" name="ispListAndBandwidth">
                                    @if(isset($dataTypeContent->isp_list_and_bandwidth)){{ $dataTypeContent->isp_list_and_bandwidth }}@endif
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="listStaticIpPublic">Do they have static IP Public? Please list</label>
                                <textarea class="form-control" id="listStaticIpPublic" name="listStaticIpPublic">
                                    @if(isset($dataTypeContent->list_static_ip_public)){{ $dataTypeContent->list_static_ip_public }}@endif
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="branchNeedConnectToHq">Do their Branch Office need to connect to HQ?</label>
                                <textarea class="form-control" id="branchNeedConnectToHq" name="branchNeedConnectToHq">
                                    @if(isset($dataTypeContent->branch_need_connect_to_hq)){{ $dataTypeContent->branch_need_connect_to_hq }}@endif
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="useWifiAsConnectionToDeviceAndPc">Do they use WiFi as connection for their device and PCs?</label>
                                <textarea class="form-control" id="useWifiAsConnectionToDeviceAndPc" name="useWifiAsConnectionToDeviceAndPc">
                                    @if(isset($dataTypeContent->use_wifi_as_connection_to_device_and_pc)){{ $dataTypeContent->use_wifi_as_connection_to_device_and_pc }}@endif
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="giveFreeAccessToGuest">Do they give free access to Guest?</label>
                                <textarea class="form-control" id="giveFreeAccessToGuest" name="giveFreeAccessToGuest" data-parsley-required>
                                    @if(isset($dataTypeContent->give_free_access_to_guest)){{ $dataTypeContent->give_free_access_to_guest }}@endif
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="needQos">Do they need need QoS?</label>
                                <textarea class="form-control" id="needQos" name="needQos">
                                    @if(isset($dataTypeContent->give_free_access_to_guest)){{ $dataTypeContent->give_free_access_to_guest }}@endif
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="needCaptivePortalForWifiAccess">Do They need captive portal to their WiFi access?</label>
                                <textarea class="form-control" id="needCaptivePortalForWifiAccess" name="needCaptivePortalForWifiAccess" data-parsley-required>
                                    @if(isset($dataTypeContent->give_free_access_to_guest)){{ $dataTypeContent->give_free_access_to_guest }}@endif
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><!--<i class="icon wb-clipboard"></i>--> Opportunity Info</h3>
                            <div class="panel-actions">
                                <a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="opportunityOrCustomerNeeds">Describe the opportunity/ customer needs</label>
                                <textarea class="form-control" id="opportunityOrCustomerNeeds" name="opportunityOrCustomerNeeds" data-parsley-required>
                                    @if(isset($dataTypeContent->opportunity_or_customer_needs)){{ $dataTypeContent->opportunity_or_customer_needs }}@endif
                                </textarea>
                            </div>

                            <div class="form-group form-group-sm">
                                <div>Describe the Ransnet products you recommend to offer?</div>
                                @php
                                $number = 0;
                                @endphp
                                @foreach(App\Components\DealRegistration\Models\Product::all() as $product)
                                    {{--<option value="{{ $product->id }}" @if(isset($dataTypeContent->specific_industry_id) && $dataTypeContent->specific_industry_id == $product->id){{ 'selected="selected"' }}@endif>{{ $product->code }}</option>--}}
                                    <div class="col-md-6">
                                        <span>{{ $product->code }}</span>
                                        <input type="hidden" name="product[{{ $number }}][id]" value="{{ $product->id }}">
                                        <input type="text" class="form-control" name="product[{{ $number }}][qty]" placeholder="quantity" value="@if(isset($dataTypeContent->when_to_go_live)){{ $dataTypeContent->when_to_go_live }}@endif">
                                    </div>
                                    @php
                                    $number++;
                                    @endphp
                                @endforeach
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group">
                                <label for="whenToGoLive">When do they need to go live? (Is there a special reason to start?)</label>
                                <input type="text" class="form-control" id="whenToGoLive" name="whenToGoLive" placeholder="" value="@if(isset($dataTypeContent->when_to_go_live)){{ $dataTypeContent->when_to_go_live }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="dealCloseOfDate">Expected close date for this deal?</label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control" id="dealCloseOfDate" name="dealCloseOfDate" placeholder="" value="@if(isset($dataTypeContent->deal_close_of_date)){{ $dataTypeContent->deal_close_of_date }}@endif" data-parsley-required>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="isBudgetAvailable">Is budget available?</label>
                                <input type="text" class="form-control" id="isBudgetAvailable" name="isBudgetAvailable" placeholder="" value="@if(isset($dataTypeContent->is_budget_available)){{ $dataTypeContent->is_budget_available }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="isPocNeeded">Is POC needed?</label>
                                <input type="text" class="form-control" id="isPocNeeded" name="isPocNeeded" placeholder="" value="@if(isset($dataTypeContent->is_poc_needed)){{ $dataTypeContent->is_poc_needed }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="competitorPocInstalled">Are competitors on radar? Any competitor POC installed?</label>
                                <input type="text" class="form-control" id="competitorPocInstalled" name="competitorPocInstalled" placeholder="" value="@if(isset($dataTypeContent->competitor_poc_installed)){{ $dataTypeContent->competitor_poc_installed }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="otherRelevantInfoAboutSalesProccessOrSituation">Any other relevant info about sales process/situation?</label>
                                <textarea class="form-control" id="otherRelevantInfoAboutSalesProccessOrSituation" name="otherRelevantInfoAboutSalesProccessOrSituation">
                                    @if(isset($dataTypeContent->other_relevant_info_about_sales_proccess_or_situation)){{ $dataTypeContent->other_relevant_info_about_sales_proccess_or_situation }}@endif
                                </textarea>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><!--<i class="icon wb-image"></i>--> Key People</h3>
                            <div class="panel-actions">
                                <a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="keyPeopleName">Name</label>
                                <input type="text" class="form-control" id="keyPeopleName" name="keyPeopleName" placeholder="" value="@if(isset($dataTypeContent->key_people_name)){{ $dataTypeContent->key_people_name }}@endif" data-parsley-required>
                            </div>
                            <div class="form-group">
                                <label for="keyPeoplePosition">Position (Function)</label>
                                <input type="text" class="form-control" id="keyPeoplePosition" name="keyPeoplePosition" placeholder="" value="@if(isset($dataTypeContent->key_people_position)){{ $dataTypeContent->key_people_position }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="contactMade">Contact Made</label>
                                <input type="text" class="form-control" id="contactMade" name="contactMade" placeholder="" value="@if(isset($dataTypeContent->contact_made)){{ $dataTypeContent->contact_made }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="contactOwner">Contact Owner</label>
                                <input type="text" class="form-control" id="contactOwner" name="contactOwner" placeholder="" value="@if(isset($dataTypeContent->contact_owner)){{ $dataTypeContent->contact_owner }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="interactionFrequency">Interaction Frequency</label>
                                <input type="text" class="form-control" id="interactionFrequency" name="interactionFrequency" placeholder="" value="@if(isset($dataTypeContent->interaction_frequency)){{ $dataTypeContent->interaction_frequency }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="dealRole">Deal Role</label>
                                <input type="text" class="form-control" id="dealRole" name="dealRole" placeholder="" value="@if(isset($dataTypeContent->deal_role)){{ $dataTypeContent->deal_role }}@endif">
                            </div>

                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><!--<i class="icon wb-search"></i>--> Plan to Close” Checklist (updated regularly)</h3>
                            <div class="panel-actions">
                                <a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="keyDecisionMaker">Who is key decision maker</label>
                                <input type="text" class="form-control" id="keyDecisionMaker" name="keyDecisionMaker" placeholder="" value="@if(isset($dataTypeContent->key_decision_maker)){{ $dataTypeContent->key_decision_maker }}@endif" data-parsley-required>
                            </div>

                            <div class="form-group">
                                <label for="projectOwner">Who is project owner</label>
                                <input type="text" class="form-control" id="projectOwner" name="projectOwner" placeholder="" value="@if(isset($dataTypeContent->project_owner)){{ $dataTypeContent->project_owner }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="compellingReasonToAct">What is compelling reason to act now</label>
                                <input type="text" class="form-control" id="compellingReasonToAct" name="compellingReasonToAct" placeholder="" value="@if(isset($dataTypeContent->compelling_reason_to_act)){{ $dataTypeContent->compelling_reason_to_act }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="roadblockIdentified">What roadblocks identified?</label>
                                <input type="text" class="form-control" id="roadblockIdentified" name="roadblockIdentified" placeholder="" value="@if(isset($dataTypeContent->roadblock_identified)){{ $dataTypeContent->roadblock_identified }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="roadblockResolved">Are roadblocks resolved?</label>
                                <input type="text" class="form-control" id="roadblockResolved" name="roadblockResolved" placeholder="" value="@if(isset($dataTypeContent->roadblock_resolved)){{ $dataTypeContent->roadblock_resolved }}@endif" >
                            </div>

                            <div class="form-group">
                                <label for="requirementsQuantifiedAndCustomerAcceptanceConfirmed">Requirements quantified and customer acceptance confirmed?</label>
                                <input type="text" class="form-control" id="requirementsQuantifiedAndCustomerAcceptanceConfirmed" name="requirementsQuantifiedAndCustomerAcceptanceConfirmed" placeholder="" value="@if(isset($dataTypeContent->requirements_quantified_and_customer_acceptance_confirmed)){{ $dataTypeContent->requirements_quantified_and_customer_acceptance_confirmed }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="technicalPathClarifiedAndCustomerAcceptanceConfirmed">Technical path clarified and customer acceptance confirmed?</label>
                                <input type="text" class="form-control" id="technicalPathClarifiedAndCustomerAcceptanceConfirmed" name="technicalPathClarifiedAndCustomerAcceptanceConfirmed" placeholder="" value="@if(isset($dataTypeContent->technical_path_clarified_and_customer_acceptance_confirmed)){{ $dataTypeContent->technical_path_clarified_and_customer_acceptance_confirmed }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="customerBudgetConfirmed">Customer budget confirmed?</label>
                                <input type="text" class="form-control" id="customerBudgetConfirmed" name="customerBudgetConfirmed" placeholder="" value="@if(isset($dataTypeContent->customer_budget_confirmed)){{ $dataTypeContent->customer_budget_confirmed }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="formalQuoteAlreadyIssuedToCustomer">Formal quote already issued to customer?</label>
                                <input type="text" class="form-control" id="formalQuoteAlreadyIssuedToCustomer" name="formalQuoteAlreadyIssuedToCustomer" placeholder="" value="@if(isset($dataTypeContent->formal_quote_already_issued_to_customer)){{ $dataTypeContent->formal_quote_already_issued_to_customer }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="whatWasOffered">What was offered?</label>
                                <input type="text" class="form-control" id="whatWasOffered" name="whatWasOffered" placeholder="" value="@if(isset($dataTypeContent->what_was_offered)){{ $dataTypeContent->what_was_offered }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="signOffFromKeyDecisionMaker">Sign off from key decision maker?</label>
                                <input type="text" class="form-control" id="signOffFromKeyDecisionMaker" name="signOffFromKeyDecisionMaker" placeholder="" value="@if(isset($dataTypeContent->sign_off_from_key_decision_maker)){{ $dataTypeContent->sign_off_from_key_decision_maker }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="signOffFromFinancier">Sign off from financier?</label>
                                <input type="text" class="form-control" id="signOffFromFinancier" name="signOffFromFinancier"  placeholder="" value="@if(isset($dataTypeContent->sign_off_from_financier)){{ $dataTypeContent->sign_off_from_financier }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="poIssued">PO issued?</label>
                                <input type="text" class="form-control" id="poIssued" name="poIssued" placeholder="" value="@if(isset($dataTypeContent->po_issued)){{ $dataTypeContent->po_issued }}@endif" data-parsley-required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id)){{ 'Update Post' }}@else<?= '<i class="icon wb-plus-circle"></i> Submit'; ?>@endif
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('streams.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script src="{{ config('streams.assets_path') }}/lib/js/tinymce/tinymce.min.js"></script>
    <script src="{{ config('streams.assets_path') }}/js/streams_tinymce.js"></script>
    <script src="{{ config('streams.assets_path') }}/lib/js/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('.datepicker').datepicker({
            todayHighlight: true
        });

        var hospitality = '<div class="panel" id="hospitality">' +
                '<div class="panel-heading">' +
                    '<h3 class="panel-title">' +
                        'Additional Account info for Hospitality Industry' +
                    '</h3>' +
                    '<div class="panel-actions">' +
                        '<a class="panel-action streams-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>' +
                    '</div>' +
                '</div>' +
                '<div class="panel-body">' +
                    '<div class="form-group">' +
                        '<label for="specificIndustry">Specific Industry</label>' +
                        '<select class="form-control" id="specificIndustry" name="specificIndustry" data-parsley-required>' +
                            '<option value=""></option>' +
                            @foreach(App\Components\DealRegistration\Models\SpecificIndustry::all() as $specificIndustry)
                                '<option value="{{ $specificIndustry->id }}" @if(isset($dataTypeContent->specific_industry_id) && $dataTypeContent->specific_industry_id == $specificIndustry->id){{ 'selected="selected"' }}@endif>{{ $specificIndustry->name }}</option>' +
                            @endforeach
                        '</select>' +
                    '</div>' +
                '<div class="form-group">' +
                    '<label for="hmsPmsSoftwareUsed">What HMS (Hotel Management System) or PMS (Property Management System) Software that they use?</label>' +
                    '<input type="text" class="form-control" id="hmsPmsSoftwareUsed" name="hmsPmsSoftwareUsed" placeholder="" value="@if(isset($dataTypeContent->hms_pms_software_used)){{ $dataTypeContent->hms_pms_software_used }}@endif">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="needIntegrationToHmsPmsSoftware">Do they need integration to their existing HMS/PMS software?</label>' +
                    '<input type="text" class="form-control" id="needIntegrationToHmsPmsSoftware" name="needIntegrationToHmsPmsSoftware" placeholder="" value="@if(isset($dataTypeContent->need_integration_to_hms_pms_software)){{ $dataTypeContent->need_integration_to_hms_pms_software }}@endif">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="numberOfRoom">How Many rooms?</label>' +
                    '<input type="text" class="form-control" id="numberOfRoom" name="numberOfRoom" placeholder="" value="@if(isset($dataTypeContent->number_of_room)){{ $dataTypeContent->number_of_room }}@endif" data-parsley-type="number">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="numberOfPublicPlace">How many public places</label>' +
                    '<input type="text" class="form-control" id="numberOfPublicPlace" name="numberOfPublicPlace" placeholder="" value="@if(isset($dataTypeContent->number_of_public_place)){{ $dataTypeContent->number_of_public_place }}@endif" data-parsley-type="number">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="minimumAndMaximumGuestUserBandwidth">Minimum and maximum guest user bandwidth</label>' +
                    '<textarea class="form-control" id="minimumAndMaximumGuestUserBandwidth" name="minimumAndMaximumGuestUserBandwidth">' +
                        @if(isset($dataTypeContent->minimum_and_maximum_guest_user_bandwidth)){{ $dataTypeContent->minimum_and_maximum_guest_user_bandwidth }}@endif
                    '</textarea>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="numberOfMeetingRooms">How many meeting rooms?</label>' +
                    '<input type="text" class="form-control" id="numberOfMeetingRooms" name="numberOfMeetingRooms" placeholder="" value="@if(isset($dataTypeContent->number_of_meeting_rooms)){{ $dataTypeContent->number_of_meeting_rooms }}@endif" data-parsley-type="number">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="meetingRoomCapacity">Meeting room capacity</label>' +
                    '<input type="text" class="form-control" id="meetingRoomCapacity" name="meetingRoomCapacity[]" placeholder="" value="@if(isset($dataTypeContent->meeting_room_capacity)){{ $dataTypeContent->meeting_room_capacity }}@endif" data-parsley-type="number">' +
                '</div>' +
                    '<button type="button" id="addMeetingRoom" class="btn btn-primary pull-right">More meeting room capacity</button>' +
                '<br />' +
                '<div class="form-group">' +
                    '<label for="numberOfBallroom">How Many Ballroom</label>' +
                    '<input type="text" class="form-control" id="numberOfBallroom" name="numberOfBallroom" placeholder="" value="@if(isset($dataTypeContent->number_of_ballroom)){{ $dataTypeContent->number_of_ballroom }}@endif" data-parsley-type="number">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label for="ballroomCapacity">Ballroom capacity</label>' +
                    '<input type="text" class="form-control" id="ballroomCapacity" name="ballroomCapacity[]" placeholder="" value="@if(isset($dataTypeContent->ballroom_capacity)){{ $dataTypeContent->ballroom_capacity }}@endif" data-parsley-type="number">' +
                '</div>' +
                '<div class="form-group addBallroom" >' +
                    '<button type="button" id="addBallroom" class="btn btn-primary pull-right">More ballroom capacity</button>' +
                '</div>' +
                '<br />';

        // Add branch address
        var number = 0;
        $("button#addBranchAddress").on("click", function() {
            number++;
            if (number < 20) {
                $("button#addBranchAddress").before('' +
                        '<div class="form-group">' +
                        '<label for="branchAddress">Branch Address ' + number + '</label>' +
                        '<input type="text" class="form-control" id="branchAddress" name="branchAddress[]" placeholder="" value="">' +
                        '</div>'
                );
            }
        });

        // Add meeting room
        var roomNumber = 0;
        $(document).on("click", "button#addMeetingRoom", function() {
            roomNumber++;
            $("button#addMeetingRoom").before('' +
                    '<div class="form-group">' +
                        '<label for="meetingRoomCapacity">Meeting room ' + roomNumber + ' capacity</label>' +
                        '<input type="text" class="form-control" id="meetingRoomCapacity" name="meetingRoomCapacity[]" placeholder="" value="">' +
                    '</div>'
            );
        });

        // Add ballroom
        var ballroomNumber = 0;
        $(document).on("click", "button#addBallroom", function() {
            ballroomNumber++;
            $("button#addBallroom").before('' +
                    '<div class="form-group">' +
                        '<label for="ballroomCapacity">Ballroom ' + ballroomNumber + ' capacity</label>' +
                        '<input type="text" class="form-control" id="ballroomCapacity" name="ballroomCapacity[]" placeholder="" value="">' +
                    '</div>'
            );
        });

        $("select#customerIndustryId").on("change", function() {
            if ($('select#customerIndustryId').find(":selected").text() == 'Hospitality') {
                $("div#account-info").after(hospitality);
            } else {
                $("div#hospitality").remove();
            }
        });

    </script>
@stop