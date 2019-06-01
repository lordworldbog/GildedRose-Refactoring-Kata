# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2019-06-01
### Added
- Unit tests
- Products entities
- Products provider

### Changed
- Все элементы массива передаваемого в конструктор App\GildedRose должны быть объектами App\Item.
- Все товары кроме Sulfuras не могут быть созданы с quality больше чем 50.
- Все товары кроме Sulfuras не могут быть созданы с quality меньше чем 0.