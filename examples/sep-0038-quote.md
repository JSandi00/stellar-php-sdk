
# SEP-0038 - Anchor RFQ API

The [SEP-38](https://github.com/stellar/stellar-protocol/blob/master/ecosystem/sep-0038.md) standard defines a way for anchors to provide quotes for the exchange of an off-chain asset and a different on-chain asset, and vice versa.
Quotes may be [indicative](https://www.investopedia.com/terms/i/indicativequote.asp) or [firm](https://www.investopedia.com/terms/f/firmquote.asp) ones.
When either is used is explained in the sections below.


## Create a `QuoteService` instance

Let's start with creating a `QuoteService` object, which we'll use for all SEP-38 interactions.
Authentication is optional for these requests, and depends on the anchor implementation. For our example we will include it.

**By providing the quote server url directly via the constructor:**

```php
$service = new QuoteService("http://api.stellar.org/quote");
```

**By providing the domain hosting the stellar.toml file**

```php
$service = QuoteService::fromDomain("place.domain.com");
```

This will automatically load and parse the `stellar.toml` file. It will then create the QuoteService instance by using the quote server url provided in the `stellar.toml` file.

## Authentication

Authentication is done using the [Sep-10 WebAuth Service](https://github.com/Soneso/stellar-php-sdk/blob/main/examples/sep-0010-webauth.md), and we will use the authentication token in the SEP-38 requests.

## Get Anchor Information

First, let's get information about the anchor's support for [SEP-38](https://github.com/stellar/stellar-protocol/blob/master/ecosystem/sep-0038.md). The response gives what stellar on-chain assets and off-chain assets are available for trading.

```php
$response = $service->info(jwt: $jwtToken);
$assets = $response->assets;
```

## Asset Identification Format

Before calling other endpoints we should understand the scheme used to identify assets in this protocol. The following format is used:

`<scheme>:<identifer>`

The currently accepted scheme values are `stellar` for Stellar assets, and `iso4217` for fiat currencies.

For example to identify USDC on Stellar we would use:

`stellar:USDC:GA5ZSEJYB37JRC5AVCIA5MOP4RHTM335X2KGX3IHOJAPP5RE34K4KZVN`

And to identify fiat USD we would use:

`iso4217:USD`

Further explanation can be found in [SEP-38 specification](https://github.com/stellar/stellar-protocol/blob/master/ecosystem/sep-0038.md#asset-identification-format).

## Get Prices

Now let's get [indicative](https://www.investopedia.com/terms/i/indicativequote.asp) prices from the anchor in exchange for a given asset. This is an indicative price. The actual price will be calculated at conversion time once the Anchor receives the funds from a user.

In our example we're getting prices for selling 5 fiat USD.

```php
$response = $service->prices(
                sellAsset: "iso4217:USD", 
                sellAmount: "5", 
                jwt: $jwtToken);

$buyAssets = $response->buyAssets;
```

The response gives the asset prices for exchanging the requested sell asset.

## Get Prices

Next, let's get an [indicative](https://www.investopedia.com/terms/i/indicativequote.asp) price for a certain pair.

Once again this is an indicative value. The actual price will be calculated at conversion time once the Anchor receives the funds from a User.

Either a `sellAmount` or `buyAmount` value must be given, but not both. And `context` refers to what Stellar SEP context this will be used for (ie. `sep6`, `sep24`, or `sep31``).

```php
$response = $service->price(
    context: "sep6",
    sellAsset: "iso4217:USD",
    buyAsset: "stellar:SRT:GCDNJUBQSX7AJWLJACMJ7I4BC3Z47BQUTMHEICZLE6MU4KQBRYG5JY6B",
    sellAmount: "5",
    jwt: $jwtToken);
```

The response gives information for exchanging these assets.

## Post Quote

Now let's get a [firm](https://www.investopedia.com/terms/f/firmquote.asp) quote from the anchor.
As opposed to the earlier endpoints, this quote is stored by the anchor for a certain period of time.
We will show how we can grab the quote again later.

```php
$request = new SEP38PostQuoteRequest(
    context: "sep6",
    sellAsset: "iso4217:USD",
    buyAsset: "stellar:SRT:GCDNJUBQSX7AJWLJACMJ7I4BC3Z47BQUTMHEICZLE6MU4KQBRYG5JY6B",
    sellAmount: "5");

$response = $service->postQuote($request, $jwtToken);

$quoteId = $response->id;
$expirationDate = $response->expiresAt;
$totalPrice = $response->totalPrice;
// ...
```
However now the response gives an `id` that we can use to identify the quote. The `expiresAt` field tells us how long the anchor will wait to receive funds for this quote.

## Get Quote

Now let's get the previously requested quote. To do that we use the `id` from the `.postQuote()` response.

```php
$response = $service->getQuote($quoteId, $jwtToken);
```
The response should match the one given from `.postQuote()` we made earlier.

### Further readings

SDK's [SEP-38 test cases](https://github.com/Soneso/stellar-php-sdk/blob/main/Soneso/StellarSDKTests/SEP038Test.php).
