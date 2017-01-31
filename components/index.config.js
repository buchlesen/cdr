import {DateToLocaleCfgConfig} from './config/dateToLocaleCfg.config';
import {RoutesConfig} from './config/routes.config';
import {LoadingBarConfig} from './config/loading_bar.config';
import {ThemeConfig} from './config/theme.config';
import {SatellizerConfig} from './config/satellizer.config';

angular.module('app.config')
    .config(DateToLocaleCfgConfig)
    .config(RoutesConfig)
    .config(LoadingBarConfig)
    .config(ThemeConfig)
    .config(SatellizerConfig);
