# Kardi-soft próbafeladat, Laravel verzió

Ebben a repoban a jelentkezésem részeként kért próbafeladat azon megoldását találod, amit Laravelben készítettem el. Létezik ezen kívül egy standalone, két PHP fájlt tartalmazó megoldása is ugyanannak a feladatnak, amit az alábbi linkről érhetsz el: [Kardi-soft próbafeladat, minimalista verzió](https://gist.github.com/webprogramozo/93a0294f203ac9d98ae37628b493ca96)

## Előfeltételek

A projekt fordításához, teszteléséhez és buildeléséhez az alábbi előfeltételeknek kell megfelelni:

- PHP v8.2
- MySQL v8
- Composer v2
- Node.js v10, npm

## Telepítés

A projekt letöltése után nincs más dolgunk, mint a composer és az npm által a szükséges további fájlokat telepíteni.

### Composer telepítés

Használd az alábbi parancsot a composer függőségek telepítéséhez. Ez telepíteni fogja az összes alapvető csomagot, továbbá az általam használt Carbon dátumkezelő könyvtárat.
```
composer install
```

### npm telepítés

Szükséges npm csomagok hozzáadása. Az alábbi paranccsal a jQuery, Bootstrap és Lodash libeket tudod a projekthez hozzáadni.
```
npm install
```

### Adatbáziskapcsolat beállítása

Egy tetszőleges MySQL kapcsolatot kell beállítanod a projekt beállításfájljában, az `.env`-ben. A következőkben egy példa beállítást mutatok, hogy a megfelelő beállításkulcsok meglegyenek.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kardisoft_task
DB_USERNAME=rootuser
DB_PASSWORD=rootpass
```

## Futtatás fejlesztői módban

Amennyiben tesztelnéd az alkalmazást, futtasd az alábbi build scriptet.
```
npm run dev
```
----------------------
Minden visszajelzést szívesen veszek. Köszönöm.
