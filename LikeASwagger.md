## Что-то типа свагера

### POST /api/v1/document – Внесение документа движения товара
Этот метод позволяет добавить новый документ типа "incoming", "outgoing" или "inventory". Документ содержит информацию о нескольких товарах.
```json
{
  "type": "inventory",
  "items": [
    {
      "productId": "123",
      "quantity": 11,
      "unitPrice": 100.5
    },
    {
      "productId": "124",
      "quantity": 6,
      "unitPrice": 95.0
    }
  ]
}
```

response: http-201
```json
{
  "documentId": "019219e1-cb48-7b57-a850-5af2816893df"
}
```

### GET /api/v1/product/{productId}/history – Получение истории движения по товарам
Метод возвращает историю движения указанного товара (все документы, влияющие на остаток товара).

response: http-200
```json
[
  {
    "documentId": "019218e3-daa0-7e6a-826c-3ecf55dbb5a0",
    "type": "incoming",
    "quantity": 10,
    "currentStock": 10,
    "inventoryError": null,
    "createdAt": "2024-09-22 08:40:36"
  },
  {
    "documentId": "01921946-275d-7b83-a7ef-8370b2425b2c",
    "type": "inventory",
    "quantity": 10,
    "currentStock": 10,
    "inventoryError": 0,
    "createdAt": "2024-09-22 10:28:00"
  },
  {
    "documentId": "01921951-8174-7b83-b36b-1d85e1f05795",
    "type": "inventory",
    "quantity": 10,
    "currentStock": 10,
    "inventoryError": 0,
    "createdAt": "2024-09-22 10:40:24"
  }
]
```

### GET /api/v1/inventory/{date} – Получение инвентаризаций за указанную дату
Этот метод возвращает данные по инвентаризации за указанную дату для всех товаров, включая рассчитанный остаток, стоимость в рублях и ошибки инвентаризации.

response: http-200
```json
[
  {
    "documentId": "019218e3-daa0-7e6a-826c-3ecf55dbb5a0",
    "type": "incoming",
    "quantity": 10,
    "currentStock": 10,
    "inventoryError": null,
    "createdAt": "2024-09-22 08:40:36"
  },
  {
    "documentId": "01921946-275d-7b83-a7ef-8370b2425b2c",
    "type": "inventory",
    "quantity": 10,
    "currentStock": 10,
    "inventoryError": 0,
    "createdAt": "2024-09-22 10:28:00"
  },
  {
    "documentId": "01921951-8174-7b83-b36b-1d85e1f05795",
    "type": "inventory",
    "quantity": 10,
    "currentStock": 10,
    "inventoryError": 0,
    "createdAt": "2024-09-22 10:40:24"
  }
]
```
