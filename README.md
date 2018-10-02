# Spryker API using GraphQL   

## How to install?
1. ```composer require inviqa/spryker-graphql```
2. Add ```Inviqa``` to ```$config[KernelConstants::CORE_NAMESPACES]``` in config_default.php
3. Add ```new GraphqlControllerProvider($isSsl)``` to ```Pyz\Yves\Application\YvesBootstrap::getControllerProviderStack()```  

## How to use?
**GraphQL endpoint:** https://\<yves host\>/graphql

### Available Queries:
#### Sample query to fetch navigation menu list:
```$json
query {
  navigation {
    nodes {
      navigationNode {
        idNavigationNode
        navigationNodeLocalizedAttributes {
          title
        }
      }
      children {
        navigationNode {
          idNavigationNode
          navigationNodeLocalizedAttributes {
            title
          }
        }
        children {
          navigationNode {
            idNavigationNode
            navigationNodeLocalizedAttributes {
              title
            }
          }
        }
      }
    }
  }
}
```
#### Sample query to fetch featured products:
```$json
query { 
  featuredProducts {
    id_product_abstract
    abstract_sku
    abstract_name
  }
}
```
#### Sample query to fetch quote items:
```$json
query {
  quote {
    items {
      sku
      quantity
      name
      sumSubtotalAggregation
      sumGrossPrice
      sumNetPrice
      abstractSku
    }
    currency {
      code
    }
    customer {
      firstName
      lastName
    }
  }
}
```

### Available Mutations:
#### Sample mutation to add an item to cart:
```$json
mutation {
  addToCart(sku: "<sku>", quantity: 1) {
      items {
        sku
        quantity
      }
  }
}
```


## TODO:
- [ ] create data resolver for all parent types manually and feed in QueryType
- [ ] (later, not decided) Use jwt token and store session ID int it, and use it to initiate session.
