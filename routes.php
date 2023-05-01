<?php

use ConstructionStages\Actions;
use ConstructionStages\Http\Router;

Router::add(method: 'get', route: 'constructionStages', action: Actions\GetAllConstructionStages::class);
Router::add(method: 'get', route: 'constructionStages/(:num)', action: Actions\GetSingleConstructionStage::class);
Router::add(method: 'post', route: 'constructionStages', action: Actions\CreateConstructionStage::class);
Router::add(method:'patch',route:  'constructionStages/(:num)', action: Actions\UpdateConstructionStage::class);