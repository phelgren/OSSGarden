import csv

# write inventory data as comma-separated values
writer = csv.writer(open('inventory.csv', 'wb', buffering=0))
writer.writerows([
    ('WIG', 'Colorful widgets', 'Blue', 300, 1.99),
    ('FOOBARS', 'Tasty Foo bars', 'Chocolate', 125, 1.75),
    ('GAG', 'Various Gadgets', 'N/A', 500, 2.29),
    ('DOODADS','Marvelous doodads','Green',1000,19.99),
    ('THINGAMABOBS','What ARE these things?','Unknown',750,4.95)
])

# read inventory data, print status messages
inventory = csv.reader(open('inventory.csv', 'rb'))
status_labels = {-1: 'low', 0: 'adequate', 1: 'over stocked'}
for stock_ID, title, description,qty, price in inventory:
    status = status_labels[cmp(int(qty), 500)]
    print '%s is %s (%s)' % (title, status, qty)
