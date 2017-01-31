class CoqpFormController{
    constructor(API, ToastService){
        'ngInject';

        this.API          = API;
        this.ToastService = ToastService;
    }

    $onInit(){
    }

    submit() {
        var data = {
            name                                                 : this.name,
            description                                          : this.description,
            partner                                              : this.partner,
            accountManagerName                                   : this.accountManagerName,
            companyName                                          : this.companyName,
            customerId                                           : this.customerId,
            hqAddress                                            : this.hqAddress,
            branchAddress1                                       : this.branchAddress1,
            branchAddress2                                       : this.branchAddress2,
            ownership                                            : this.ownership,
            siteNumber                                           : this.siteNumber,
            officeNumber                                         : this.officeNumber,
            branchNumber                                         : this.branchNumber,
            totalEmployee                                        : this.totalEmployee,
            employeeConnectToWifi                                : this.employeeConnectToWifi,
            multipleIsp                                          : this.multipleIsp,
            ispListAndBandwidth                                  : this.ispListAndBandwidth,
            listStaticIpPublic                                   : this.listStaticIpPublic,
            branchNeedConnectToHq                                : this.branchNeedConnectToHq,
            useWifiAsConnectionToDeviceAndPc                     : this.useWifiAsConnectionToDeviceAndPc,
            giveFreeAccessToGuest                                : this.giveFreeAccessToGuest,
            needQos                                              : this.needQos,
            needCaptivePortalForWifiAccess                       : this.needCaptivePortalForWifiAccess,
            specificIndustry                                     : this.specificIndustry,
            hmsPmsSoftwareUsed                                   : this.hmsPmsSoftwareUsed,
            needIntegrationToHmsPmsSoftware                      : this.needIntegrationToHmsPmsSoftware,
            numberOfRoom                                         : this.numberOfRoom,
            numberOfPublicPlace                                  : this.numberOfPublicPlace,
            minimumAndMaximumGuestUserBandwidth                  : this.minimumAndMaximumGuestUserBandwidth,
            numberOfMeetingRooms                                 : this.numberOfMeetingRooms,
            meetingRoom1Capacity                                 : this.meetingRoom1Capacity,
            meetingRoom2Capacity                                 : this.meetingRoom2Capacity,
            meetingRoom3Capacity                                 : this.meetingRoom3Capacity,
            numberOfBallroom                                     : this.numberOfBallroom,
            ballroom1Capacity                                    : this.ballroom1Capacity,
            ballroom2Capacity                                    : this.ballroom2Capacity,
            ballroom3Capacity                                    : this.ballroom3Capacity,
            opportunityOrCustomerNeeds                           : this.opportunityOrCustomerNeeds,
            ransnetProductsRecommended                           : this.ransnetProductsRecommended,
            whenToGoLive                                         : this.whenToGoLive,
            dealCloseOfDate                                      : this.dealCloseOfDate,
            isBudgetAvailable                                    : this.isBudgetAvailable,
            isPocNeeded                                          : this.isPocNeeded,
            competitorPocInstalled                               : this.competitorPocInstalled,
            otherRelevantInfoAboutSalesProccessOrSituation       : this.otherRelevantInfoAboutSalesProccessOrSituation,
            keyPeopleName                                        : this.keyPeopleName,
            keyPeoplePosition                                    : this.keyPeoplePosition,
            contactMade                                          : this.contactMade,
            contactOwner                                         : this.contactOwner,
            interactionFrequency                                 : this.interactionFrequency,
            dealRole                                             : this.dealRole,
            keyDecisionMaker                                     : this.keyDecisionMaker,
            projectOwner                                         : this.projectOwner,
            compellingReasonToAct                                : this.compellingReasonToAct,
            roadblockIdentified                                  : this.roadblockIdentified,
            roadblockResolved                                    : this.roadblockResolved,
            requirementsQuantifiedAndCustomerAcceptanceConfirmed : this.requirementsQuantifiedAndCustomerAcceptanceConfirmed,
            technicalPathClarifiedAndCustomerAcceptanceConfirmed : this.technicalPathClarifiedAndCustomerAcceptanceConfirmed,
            customerBudgetConfirmed                              : this.customerBudgetConfirmed,
            formalQuoteAlreadyIssuedToCustomer                   : this.formalQuoteAlreadyIssuedToCustomer,
            whatWasOffered                                       : this.whatWasOffered,
            signOffFromKeyDecisionMaker                          : this.signOffFromKeyDecisionMaker,
            signOffFromFinancier                                 : this.signOffFromFinancier,
            poIssued                                             : this.poIssued
        };

        this.API.all('coqp').post(data).then((response) => {
            this.ToastService.show('Data added successfully');
        });
    }
}

export const CoqpFormComponent = {
    templateUrl: './views/app/components/coqp-form/coqp-form.component.html',
    controller: CoqpFormController,
    controllerAs: 'vm',
    bindings: {}
};
