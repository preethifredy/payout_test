# Instructions

1. First upload the payout.sql in database.
2. To add the user -> http://localhost/payout_test/add-user
3. To add the user hierarchy -> http://localhost/payout_test/add-hierarchy
     Here you can select a user and a parent user to set the hierarchy. Here user is a mandatory. If you didnt select the parent for a user then that user is the top most user of that hierarchy. If user has atleast only child then only it will come under parent dropdown.
4. To record the sale -> http://localhost/payout_test/record-sale
    Here you can select a user who makes a sale and add the amount. When click on record sale button the sale is recoreded and commissions is distributed upto 5 level users

