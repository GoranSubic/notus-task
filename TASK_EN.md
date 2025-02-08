# Task

- A `Provider.php` file needs to be created inside the `app` folder where the following API calls need to be implemented
  - `https://dummyjson.com/products` - List of products with pagination and possibility of ordering
    - Parameters
      - limit
      - skip
      - sortBy
      - order (asc, desc)
  - `https://dummyjson.com/products/{id}` - Single product
  - `https://dummyjson.com/products/search?q=search+query` - Product search

- Parsers `Parser.php` file needs to be created inside the `app` folder where you will work the the fetched data and parse them to the wanted formats for the response listed below
  - Product list (search should be the same response)

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

  - Single product

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

- All of the methods from the providers need to be accessible from a `Controller` and GET routes need to be ccreated
  - A [router](https://github.com/bramus/router) is setup
  - A http client (guzzle) is also inside the composer for API requests

A solution needs to be on a source control platform (preferably GitHub) and shared it with us "robert.jarec@notus.hr".

A deadline for the solution is 4 days from the day after we send the task.
