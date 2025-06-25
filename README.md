# Laravel CSV Export

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blueviolet)
![Laravel Version](https://img.shields.io/badge/Laravel-11.x%2B-red)
![License](https://img.shields.io/badge/License-MIT-green)
![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)

A robust Laravel package for exporting Eloquent models to CSV files with ease.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Examples](#examples)


## Features ✨

- 🚀 Export any Eloquent model with a single command
- 📦 Handles large datasets efficiently with chunked exports
- 🌐 Multiple storage options (local, S3, etc.)
- ⚙️ Fully configurable through config file or command options
- 📅 Automatic date formatting
- 🔍 Progress feedback during export
- 🛡️ Comprehensive error handling

## Installation

Install via Composer:

# 1. Install the package via Composer
```bash
composer require your-vendor/laravel-csv-export
```

# 2. (Optional) Publish the configuration file
```bash
php artisan vendor:publish --tag=csv-export-config
```
### 3. (Optional) Verify the package is registered (for Laravel <11)
### Add this to config/app.php providers if not auto-discovered:
### YourVendor\CsvExport\CsvExportServiceProvider::class


## Usage

### Basic Command
```bash
php artisan export:csv "Fully\\Qualified\\ModelName"
```
### Advanced Options
### Option	Description	Default	Example Usage

- disk	Storage disk (local/s3/etc)	local	--disk=s3
- directory	Export directory path	exports	--directory=monthly_backups
- filename	Export filename (%s=timestamp)	export_%s.csv	--filename=users_2024.csv
- chunk-size	Records processed per batch	1000	--chunk-size=5000
- no-headers	Exclude column headers	false	--no-headers
- columns	Specific columns to export	All columns	--columns=id,name,email
Real-world Examples
- 
Export Users to S3 with custom filename:

php artisan export:csv "App\\Models\\User" --disk=s3 --filename=user_export_%s.csv

2. Large dataset export with progress:
```bash
php artisan export:csv "App\\Models\\LogEntry" --chunk-size=5000

php artisan export:csv "App\\Models\\LogEntry" --chunk-size=5000
```
Partial export with specific columns:

```bash
php artisan export:csv "App\\Models\\Product" --columns=id,sku,name,price
```
System integration (headerless CSV):

```bash
php artisan export:csv "App\\Models\\Transaction" --no-headers --filename=transactions.csv
```
Programmatic Usage
```
use YourVendor\CsvExport\Facades\CsvExport;
```
// Basic export
``` code
CsvExport::model(\App\Models\User::class)->export();
```
// Advanced export
``` code
CsvExport::model(\App\Models\Order::class)
    ->disk('s3')
    ->filename('orders_'.now()->format('Y-m-d').'.csv')
    ->columns(['id', 'total', 'created_at'])
    ->export();
```

## Configuration

### 1. Publishing Config File
First publish the configuration file:
```bash
php artisan vendor:publish --tag=csv-export-config

```

## Examples

### 1. Basic Model Export
Export all users to default location:
```bash
php artisan export:csv "App\Models\User"
```
### Large Dataset Handling
```
php artisan export:csv "App\Models\Order" \
--chunk-size=5000 \
--filename=large_orders.csv
```
