export function DateToLocaleCfgConfig($mdDateLocaleProvider){
    'ngInject';

    $mdDateLocaleProvider.formatDate = function(date) {
        return moment(date).format('YYYY-MM-DD');
    };
}
