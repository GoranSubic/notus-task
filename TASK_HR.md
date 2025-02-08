# Task

- Potrebno je kreirati `Provider.php` unutar `app` folder unutar kojeg će se dohvaćati podatci sa niže navedenih API endpointova
  - `https://dummyjson.com/products` - Lista proizvoda sa paginacijom i mogućnosti sortiranja
    - Parametri
      - limit
      - skip
      - sortBy
      - order (asc, desc)
  - `https://dummyjson.com/products/{id}` - Pojedini proizvod
  - `https://dummyjson.com/products/search?q=search+query` - Pretraga proizvoda

- Potrebno je kreirati `Parser.php` unutar `app` foldera koji će raditi sa dohvaćenim podacima te ih parsirati u nama željene formate za response
  - Lista proizvoda (isto je i kod pretrage)

    ```json
    {
        "data": [
            {
                "id": 1,
                "title": "Title of product",
                "description": "Full description",
                "short_description": "30 characters of the full description",
                "price": "Price formatted to currency (EURO)",
                "stock": "0 = No stock, < 5 = Get it while you can, >= 5 = On Stock",
                "thumbnail": "link"
            }
        ],
        "meta": {
            "total_pages": "total_pages",
            "page": "page",
            "per_page": "per page"
        }
    }
    ```

  - Pojedini proizvod

    ```json
    {
        "id": 1,
        "title": "Title of product",
        "description": "Full description",
        "category": "category",
        "tags": "Tags separated by comma"
        "price": "Price formatted to currency (EURO)",
        "stock": "0 = No stock, < 5 = Get it while you can, >= 5 = On Stock",
        "thumbnail": "link"
    }
    ```

- Za sve kreirane metode iz providera potrebno je napraviti Rute kroz koje se mogu dohvatiti sve navedene stvari kroz GET zahtjeve - poželjno napraviti metode koje se pozivaju u routeru kroz `Controller`
  - Postavljen je [router](https://github.com/bramus/router)
  - Također je u composeru postavljen i guzzle kao alat za requestove

Rješenje je potrebno postaviti na source control platform (poželjno GitHub) te podijeliti sa "robert.jarec@notus.hr"

Rok za rješenje je 4 dana od dana nakon što pošaljemo zadatak.
