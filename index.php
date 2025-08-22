<?php
require_once __DIR__ . '/bootstrap.php';

$router = new Router();

// Web route
$router->get('/', 'DashboardController@index');

// Budgets routes
$router->get('/budgets', 'BudgetsController@index');
$router->get('/budgets/create', 'BudgetsController@create');
$router->post('/budgets/store', 'BudgetsController@store');
// Edit/Update/Delete routes (IDs via query/form since router does exact path match)
$router->get('/budgets/edit', 'BudgetsController@edit'); // ?id=123
$router->post('/budgets/update', 'BudgetsController@update');
$router->post('/budgets/delete', 'BudgetsController@delete');

// Sources of Funds routes
$router->get('/sources', 'SourcesOfFundsController@index'); // alias to /sources/index
$router->get('/sources/index', 'SourcesOfFundsController@index'); // ?budget_id=123
$router->get('/sources/create', 'SourcesOfFundsController@create'); // ?budget_id=123
$router->post('/sources/store', 'SourcesOfFundsController@store'); // budget_id, source_name, amount
$router->get('/sources/edit', 'SourcesOfFundsController@edit'); // ?budget_id=123&id=456
$router->post('/sources/update', 'SourcesOfFundsController@update'); // budget_id, id, amount
$router->post('/sources/delete', 'SourcesOfFundsController@delete'); // budget_id, id

// Disbursements routes (custom MVC)
$router->get('/disbursements', 'DisbursementsController@index');
$router->get('/disbursements/create', 'DisbursementsController@create');
$router->post('/disbursements/store', 'DisbursementsController@store');

// Daily Ceiling routes
$router->get('/daily-ceiling', 'DailyCeilingController@index');
$router->post('/daily-ceiling/store', 'DailyCeilingController@store');
$router->get('/daily-ceiling/export', 'DailyCeilingController@exportExcel');
$router->post('/daily-ceiling/import', 'DailyCeilingController@importExcel');
// Simple API for per-category ceiling get/set (latest budget)
$router->get('/daily-ceiling/get', 'DailyCeilingController@getCategory');
$router->post('/daily-ceiling/set', 'DailyCeilingController@setCategory');
// Logs per category
$router->get('/daily-ceiling/logs', 'DailyCeilingController@logs');

// Per-budget daily ceilings view
$router->get('/daily-ceilings', 'BudgetDailyCeilingController@index'); // ?budget_id=123

// Fund-source category allocations (save & auto-calc daily ceiling)
$router->post('/budgets/save', 'AllocationsController@save');

// Reports route
$router->get('/reports', 'ReportsController@index');
// Daily and Monthly reports
$router->get('/reports/daily', 'ReportsController@daily');
$router->get('/reports/monthly', 'ReportsController@monthly');
// Fund history report
$router->get('/reports/fund-history', 'ReportsController@fundHistory');
// Annual matrix report (by source x category)
$router->get('/reports/annual', 'ReportsController@annual');
// Annual CSV export
$router->get('/reports/annual.csv', 'ReportsController@annualCsv');

// Assistance (CI-like) endpoints for report and set_ceiling semantics
$router->get('/assistance/report', 'AssistanceController@report'); // ?category=Hospital
$router->post('/assistance/set-ceiling', 'AssistanceController@set_ceiling');

// API routes
$router->get('/api/status', 'ApiController@status');
$router->get('/api/dashboard-status', 'ApiController@dashboardStatus');
$router->get('/api/calendar-events', 'ApiController@calendarEvents');
$router->get('/api/exports/disbursements.csv', 'ApiController@exportCsv');
$router->get('/api/allocations/daily-ceilings', 'ApiController@allocationsDailyCeilings'); // ?fund_source_id=123
$router->get('/api/exports/disbursements.pdf', 'ApiController@exportPdf');
$router->get('/api/daily-trend', 'ApiController@dailyTrend');
$router->get('/api/disbursements', 'ApiController@disbursements');
$router->get('/api/fund-history', 'ApiController@fundHistory');
$router->get('/api/daily-ceilings', 'ApiController@dailyCeilings');
$router->post('/api/settings', 'ApiController@setCeiling');
$router->post('/api/funds', 'ApiController@saveFund');
$router->post('/api/funds/delete', 'ApiController@deleteFund');
$router->post('/api/disburse', 'ApiController@disburse');
$router->post('/api/budget-settings', 'ApiController@budgetSettings');

// Settings routes
$router->post('/settings/reset-transactions', 'SettingsController@resetTransactions');

$router->dispatch();
