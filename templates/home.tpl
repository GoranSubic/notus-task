
<h1>Notus Task</h1>

<div class="container">
    <ul>
        <li>
            <span>List of products with pagination</span>
            <a href="/products/3/11/title/asc" target="_blank">Get Products</a>
        </li>
        <li>
            <form action="/product/" method="get" target="_blank">
                <label for="product-id">Enter Product ID:</label>
                <input type="number" id="product-id" name="id" required>
                <button type="submit">Display Single Product</button>
                <script>
                    document.querySelector('form').addEventListener('submit', function(event) {
                        event.preventDefault();
                        var productId = document.getElementById('product-id').value;
                        window.open('/product/' + productId, '_blank');
                    });
                </script>
            </form>
        </li>
        <li>
            <span>Search products by title and description</span>
            <form action="/products/search" method="get" target="_blank">
                <label for="query">Search Query:</label>
                <input type="text" id="query" name="q" required>

                <label for="limit">Limit:</label>
                <input type="number" id="limit" name="limit">

                <label for="skip">Skip:</label>
                <input type="number" id="skip" name="skip">

                <button type="submit">Search</button>
                <script>
                    document.querySelector('form[action="/products/search"]').addEventListener('submit', function(event) {
                        event.preventDefault();
                        var query = document.getElementById('query').value;
                        var limit = document.getElementById('limit').value;
                        limit = limit === '' ? 10 : limit;
                        var skip = document.getElementById('skip').value;
                        skip = skip === '' ? 0 : skip;

                        console.log('skip is ', skip);
                        window.open('/products/search?q=' + query + '&limit=' + limit + '&skip=' + skip, '_blank');
                    });
                </script>
            </form></li>
    </ul>
</div>

<style>
    h1 {
        text-align: center;
    }
    ul {
        list-style-type: none;
        padding: 0;
        margin: 24 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    li {
        margin: 10px;
    }
    .container {
        display: flex;
        justify-content: center;
    }
</style>