from selenium import webdriver
from time import sleep
# Data manipulation
import pandas as pd
# Visualization
import matplotlib.pyplot as plt
import seaborn as sns
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC



driver = webdriver.Chrome(executable_path="C:/Users/ONUR/Desktop/chromedriver.exe")
migros_arama = "hyundai getz"

driver.get("https://www.sahibinden.com/")
sleep(4)



#arama
driver.find_element_by_xpath('//*[@id="searchText"]')\
    .send_keys(migros_arama)
driver.find_element_by_xpath('//*[@id="searchSuggestionForm"]/button')\
    .click()
sleep(3)

#çerezleri kabul etme
driver.find_element_by_xpath('//*[@id="onetrust-accept-btn-handler"]')\
    .click()
sleep(3)


driver.execute_script("arguments[0].click();", WebDriverWait(driver, 20).until(EC.element_to_be_clickable((By.XPATH, '//*[@id="searchResultsSearchForm"]/div/div[3]/div[3]/div[2]/ul/li[2]/a'))))

sleep(3)
    
    
item_titles = driver.find_elements_by_xpath('//*[@id="searchResultsTable"]/tbody/tr[*]/td[2]')
item_prices = driver.find_elements_by_xpath('//*[@id="searchResultsTable"]/tbody/tr[*]/td[3]')
item_loca = driver.find_elements_by_xpath('//*[@id="searchResultsTable"]/tbody/tr[*]/td[5]')
item_date = driver.find_elements_by_xpath('//*[@id="searchResultsTable"]/tbody/tr[*]/td[4]')


# boş liste
titles_list = []
prices_list = []
loca_list = []
date_list = []

# Loop over the item_titles and item_prices
for title in item_titles:
    titles_list.append(title.text)
for prices in item_prices:
    prices_list.append(prices.text)
for locat in item_loca:
    loca_list.append(locat.text)
for dat in item_date:
    date_list.append(dat.text)




print(titles_list)
print(prices_list)
print(loca_list)
print(date_list)

driver.close()