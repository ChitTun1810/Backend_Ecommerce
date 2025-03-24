<table style="table-layout: fixed;">
    <thead>
        <tr>
            <th style="font-weight: bold" width="20" height="30">Name</th>
            <th style="font-weight: bold" width="20" height="30">Sku</th>
            <th style="font-weight: bold" width="20" height="30">Stocks</th>
            <th style="font-weight: bold" width="20" height="30">Brand</th>
            <th style="font-weight: bold" width="20" height="30">Category</th>
            <th style="font-weight: bold" width="20" height="30">Sub Category</th>
            <th style="font-weight: bold" width="20" height="30">Sub Child</th>
            <th style="font-weight: bold" width="20" height="30">Product Type</th>
            <th style="font-weight: bold" width="20" height="30">Price</th>
            <th style="font-weight: bold" width="20" height="30">Country</th>
            <th style="font-weight: bold" width="20" height="30">Description</th>
            <th style="font-weight: bold" width="20" height="30">Key Information</th>
            <th style="font-weight: bold" width="20" height="30">Specification</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $key => $product)
            <tr>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->sku }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->stocks }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->brand?->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->category?->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->subCategory?->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->subChild?->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->productType?->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->price }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->country?->name }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->description }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->key_information }}</td>
                <td style="word-wrap: break-word;" width="20" height="30">{{ $product->specification }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
