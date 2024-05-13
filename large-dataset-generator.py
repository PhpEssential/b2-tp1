import csv
import numpy as np
import datetime

print("Start data generated and saved to stock_movement_data.csv")

# Number of records to generate
num_records = 1000000

date = datetime.datetime.now().isoformat()
with open("stock_movement_data.csv", "w", newline='') as f:
    spamwriter = csv.writer(f, delimiter=',', quotechar='"', quoting=csv.QUOTE_NONNUMERIC)
    spamwriter.writerow(['id', 'article_shop_id', 'quantity', 'type_movement', 'created_by', 'updated_by', 'created_at', 'updated_at'])
    for i in range(0, num_records):
        spamwriter.writerow([
            i + 1, 
            np.random.randint(1, 5), 
            np.random.randint(1, 100),
            np.random.randint(1, 5),
            "NULL",
            "NULL",
            date,
            date
        ])
print("Data generated and saved to stock_movement_data.csv")
