# 🌍 Global Supply Chain AI Dashboard

> AI-Based Global Supply Chain Risk Intelligence System using Laravel

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)
![ChartJS](https://img.shields.io/badge/Chart.js-4-orange)
![Leaflet](https://img.shields.io/badge/Leaflet-Interactive-green)
![License](https://img.shields.io/badge/license-MIT-success)

# 📖 Overview

Global Supply Chain AI Dashboard merupakan sistem monitoring rantai pasok global yang dibangun menggunakan Laravel.

Sistem ini membantu perusahaan importir maupun eksportir dalam memonitor kondisi perdagangan internasional secara real-time menggunakan berbagai sumber data eksternal seperti:

- Weather API
- Currency API
- World Bank API
- News API
- OpenStreetMap
- REST Countries API

Selain monitoring, sistem juga melakukan analisis risiko menggunakan algoritma AI sederhana (Rule-Based & Weighted Risk Model) tanpa menggunakan layanan AI berbayar.


# 🚀 Main Features

## 🌍 Country Monitoring

- 244 Countries
- Country Detail
- GDP
- Inflation
- Currency
- Weather
- Economic Status
- AI Recommendation


## 🌦 Weather Monitoring

Realtime Weather

- Temperature
- Rainfall
- Wind Speed
- Storm Risk
- Weather History


## 💱 Currency Monitoring

- Currency Exchange
- Exchange Rate History
- Highest Currency
- Lowest Currency
- Average Currency
- Currency Trend
- Top 10 Exchange Rate
- Currency by Region
- Search Currency


## 📰 Global News

Realtime News

- News Cache
- News Category
- News Source
- News Sentiment
- AI Sentiment Analysis


## 🧠 Sentiment Analysis

Lexicon Based Sentiment Analysis

Positive Dictionary

growth
increase
profit
stable
improve


Negative Dictionary

war
crisis
inflation
delay
disaster


Output

Positive

Neutral

Negative



## ⚠ Supply Chain Risk Prediction

Weighted Risk Model


Weather Risk

Inflation Risk

Currency Risk

Political Risk

Transport Risk

Economic Risk

News Risk


Output


Risk Score

Low

Medium

High



## 🚢 Port Monitoring

- Port Capacity
- Congestion
- Delay
- Transport Risk
- Historical Trend
- AI Prediction


## 🤖 AI Recommendation Engine

Generate recommendation based on:

- Risk Level
- Weather
- Economy
- Currency
- Transport

Example


Monitor shipment.

Prepare alternative logistics route.

Increase safety stock.

Avoid high risk country.



## 📊 Dashboard Analytics

Charts

- GDP Trend
- Inflation Trend
- Currency Trend
- Risk Trend
- Transport History
- Risk Comparison


## 🗺 Interactive Map

Leaflet Map

- Country Marker
- Port Marker
- Country Detail
- OpenStreetMap


## ⭐ Watchlist

Save favorite countries


## 📈 Comparison

Compare multiple countries

- GDP
- Inflation
- Currency
- Weather
- Risk


# 🧠 AI Modules

Project menggunakan AI sederhana tanpa layanan AI berbayar.

### Lexicon Based Sentiment Analysis

Positive Words

Negative Words

### Recommendation Engine

Rule Based Recommendation

### Weighted Risk Model

Weather

Inflation

Currency

Political News

Transport

GDP

Population

# 🛠 Tech Stack

Backend

- Laravel 13
- PHP 8.3
- MySQL

Frontend

- Bootstrap 5
- Chart.js
- Leaflet.js
- FontAwesome

Database

- MySQL


# 🌐 External APIs

| API | Function |
|------|----------|
| Open Meteo API | Weather |
| World Bank API | GDP |
| Exchange Rate API | Currency |
| News API | News |
| REST Countries API | Country Data |
| OpenStreetMap | Map |
| Leaflet | Interactive Map |


# 📂 Database Tables

Main Tables

users

countries

ports

password_reset_tokens

weather_data

currencies

economic_data

exchange_rate

exchange_rate_histories

risk_scores

risk_histories

migrations

articles

watchlists

positive_words

negative_words

news_cache

sentiment_results

sessions

transport_histories

notifications


# REST API

GET /api/countries

GET /api/weather

GET /api/currency

GET /api/news

GET /api/risk

GET /api/ports


# 📷 Dashboard Modules

✔ Dashboard

✔ Countries

✔ Weather

✔ Currency

✔ News

✔ Ports

✔ Port Monitoring

✔ Comparison

✔ Watchlist

✔ Sentiment

✔ Risk Score

✔ Admin


# Installation

Clone repository

bash
git clone https://github.com/Elsima09/global-supply-chain.git


Masuk folder

bash
cd global-supply-chain


Install dependency

bash
composer install


Install Node

bash
npm install


Copy env

bash
cp .env.example .env
`

Generate key

bash
php artisan key:generate


Migration

bash
php artisan migrate


Seeder

bash
php artisan db:seed


Run

bash
php artisan serve


Frontend

bash
npm run dev


# Folder Structure


app/

Models/

Controllers/

Services/

resources/

views/

public/

routes/

database/



# AI Workflow

External API

↓

Fetch Data

↓

Database

↓

Risk Calculation

↓

Sentiment Analysis

↓

Recommendation Engine

↓

Dashboard Visualization



# Author

Elsimawati Berutu
Information Systems

Global Supply Chain AI Dashboard

2026


# License

MIT License
