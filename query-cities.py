# Load json file with city data and save new file with selected fields only

selected_fields = ['geoname_id', 'name', 'ascii_name', 'cou_name_en','alternate_names', 'country', 'population']
json_file = 'geonames-all-cities-with-a-population-1000.json'
new_json_file = 'cities_selected.json'

# Load json
import json
import os

current_directory = os.getcwd()
json_file = os.path.join(current_directory, json_file)
print('Loading json...', json_file)
with open(json_file, encoding='utf-8') as f:
    cities = json.load(f)

    # create a new list with dictionaries containing only the selected fields
    new_cities = []
    for city in cities:
        new_city = {key: city[key] for key in selected_fields if key in city}
        new_cities.append(new_city)

    # Save json
    with open(new_json_file, 'w', encoding='utf-8') as f:
        print('Saving json...')
        json.dump(new_cities, f)
        print('Saved json file')


# save the new cities to mysql database
# create table if not exists
mysql = MySQLdb.connect(host='localhost', user='root', passwd='<PASSWORD>', db='geonames')

# insert data

print('Done')