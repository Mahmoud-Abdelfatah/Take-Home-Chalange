# Take-Home-Chalange
## Program Description:
To descript what the program do properly first must descript its content 
### Database: we have 5 tables 
1. Cart Table: where we save selected products by user it has 4 columns {id,user_id,product_id,quantity} user_id is for relating cart data to spacif user , product_id for product select and quantity for the quantity select by user of that product
2. Products Table: where we save our product and the discount that related to single product it has 4 columns {product_id,name,price,single_product_discount} single_product_dicount field for give discount of single product like 10% discount on shoes we but that discount on that field 
3. Promotions and promotions_rules Tables: where we handle multiple products offer in the Promotions table we save {promotion_id,discount value , and the product that will apply discount on 
4. promotions_rules Table: where we save the rules of any offer by{role_id,and promotions _id related to promotion_id  in the Promotions table , product_id,quantity} example: Buy two t-shirts and get jacket have its price so T-shirts>=2 and jacket>=1 are our rules and 50 is our discount 
5. Currency Table: where we save available {currency_name,value assuming defult currency is US Dolar so we convert from US to any ,and the sign of the currency }


### Code: we have 4 folder 
1. Controller Folder: where we handle the core requests in our program.
2. Core  Folder : where we have Global initialization variables and functions.
3. Database Folder : where there is a backup and database creation  file.
4. View: where we display our result to be shown to the user 






## How to Run the Program:
 I used REST Api solution to input and display the result throw the following steps:
1. I used post man to throw input to the program using link http://localhost/take_home_challenge/controller/Api_controller.class.php  and select method was POST
2. The input will be in a Json form and will contain {user_id} ,{product_id},{quantity}, and optional currency 
```
[{
    "user_id" : 1,
    "product_id" : 1,
    "quantity" : 2
},
{
    "user_id" : 1,
    "product_id" : 3,
    "quantity" : 1
},
{
    "user_id" : 1,
    "product_id" : 4,
    "quantity" : 1
},
{
    "currancy" : 3
}
] 
```
3. The result will appear as expexted 
```
your Bill Details
Subtotal: $ 66.96
Taxes: $ 9.37
Discounts:
     50% off Jacket -$ 9.995
     10% off Shoes -$ 2.499
Total: $ 63.836
```
