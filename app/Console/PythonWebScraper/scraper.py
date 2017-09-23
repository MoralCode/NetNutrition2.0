from bs4 import BeautifulSoup
import requests
import re
import time
import urllib
import json

def scrapeCenters(page):
    scraper = BeautifulSoup(page, "lxml")
    data = []

    #get list of dining centers
    table = scraper.find_all('table')[2]
    tags = table.find_all('tr')
    for tag in tags:
        name = tag.text
        #use a regex to get the unit id from javascript:selectUnit(41)
        uid = re.findall('selectUnit\(([^)]+)\\)',str(tag))[0]
        data.append({'name':name, 'uid':uid})

    return data

def scrapeStations(page):
    scraper = BeautifulSoup(page, "lxml")

    table = scraper.find_all('table')[3]
    #get name of stations
    tags = table.find_all('td', class_='cbo_nn_NetNutritionUnit')
    names = []
    for tag in tags:
        names.append(tag.text)

    if len(names) == 0:
        return []

    #get uids for each stats
    tags = table.find_all('tr')
    uids = []
    for tag in tags:
        uid = re.findall('selectUnit\(([^)]+)\\)',str(tag))[0]
        uids.append(uid)

    stations = []
    for i in range(len(names)):
      stations.append({'name':names[i], 'uid':uids[i]})

    return stations

def scrapeDates(page):
    scraper = BeautifulSoup(page, 'lxml')
    table = scraper.find_all('table')[3]
    tags = table.find_all('td', class_='cbo_nn_NNDisplayDate')
    dateStrings = []
    for tag in tags:
       dateStrings.append(tag.text)

    if len(dateStrings) == 0:
        return []

    tags = table.find_all('tr')
    dateStamps = []
    for tag in tags:
        date = re.findall("showMenusForDate\(\'([^)]+)\\'\)",str(tag))[0]
        dateStamps.append(date)

    dates = []
    for i in range(len(dateStrings)):
        dates.append({'dateString':dateStrings[i], 'dateStamp':dateStamps[i]})

    return dates

def scrapeMeals(page):
    scraper = BeautifulSoup(page, 'lxml')
    table = scraper.find_all('table')[4]
    tags = table.find_all('td', class_='cbo_nn_DisplayMealRow')
    mealNames = []
    for tag in tags:
       mealNames.append(tag.text)

    if len(mealNames) == 0:
        return []

    tags = table.find_all('tr')
    mealIds = []
    for tag in tags:
        id = re.findall("selectMenu\((.*?)\)",str(tag))[0]
        mealIds.append(id)

    meals = []
    for i in range(len(mealNames)):
        meals.append({'name':mealNames[i], 'id':mealIds[i]})

    return meals

# returns a list of food ids
def scrapeFoods(page):
    scraper = BeautifulSoup(page, 'lxml')
    tags = scraper.find_all('td', class_='cbo_nn_ItemNutritionButton')
    foods = []
    for tag in tags:
        id = re.findall("showItemNutrition\((.*?)\)",str(tag))[0]
        foods.append(id)

    return foods

def crawlFoods(foods, session):
    labelUrl = 'http://netnutrition.dining.iastate.edu/NetNutrition/2015/Mobile/ShowItemNutrition?detailOid='

    foodData = []
    for foodId in foods:
        url = labelUrl + foodId + '&scrollPos=0'
        page = session.get(url)

        try:
            foodNutritionData = scrapeLabel(page.text)
        except:
            foodNutritionData = {}
        foodData.append(foodNutritionData)

        session.get(goBackUrl + 'Items')
        
    return foodData

def scrapeLabel(page):
    info = {}

    scraper = BeautifulSoup(page, 'lxml')
    table = scraper.find('table', class_='cbo_nn_NutritionLabelTable')

    #get food title
    tag = table.find('td', class_='cbo_nn_LabelHeader')
    info['name'] = tag.text
    print(info['name'])

    #get serving size
    tag = table.find('td', class_='cbo_nn_LabelBottomBorderLabel')
    info['servingSize'] = tag.text.split("Serving Size:")[1]


    #get calories
    tag = table.find( class_='cbo_nn_LabelDetailIncomplete')
    if (tag == None):
        tag = table.find( class_='cbo_nn_SecondaryNutrient')

    info['Calories'] = tag.text

    
    #Get primary nutritional info
    tags = table.find_all('td', class_='cbo_nn_LabelDetail')
    #trim off first on since we already handled calories
    tags = tags[1:]
    
    for tag in tags:
        label = tag.contents[0].text.split(':')[0]
        valueTag  = tag.findNext('td').find(class_='cbo_nn_LabelDetailIncomplete')
        if (valueTag == None):
            valueTag  = tag.findNext('td').find(class_='cbo_nn_SecondaryNutrient')
        
        if (valueTag == None):
            continue
        
        value = valueTag.text
        info[label] = value
    return info

def crawlDates(dates, session):
    mealsUrl = 'http://netnutrition.dining.iastate.edu/NetNutrition/2015/Mobile/SelectDate?dateStr='

    datesData = {}
    for date in dates:
        url = mealsUrl + urllib.parse.quote(date['dateStamp'])
        page = session.get(url)
        meals = scrapeMeals(page.text)

        #some dates do not have seperate links for breakfast,lunch etc
        if len(meals) == 0:
                foods = scrapeFoods(page.text)
                datesData[date['dateString']] = {'foods':foods}
                foodsData = crawlFoods(foods, session)
                datesData[date['dateString']] = { 'meals': {'daily': {'foods':foodsData}}}
        else:
            foodsUrl = 'http://netnutrition.dining.iastate.edu/NetNutrition/2015/Mobile/SelectMenu?menuOid='

            mealData = {}
            for meal in meals:
                page  = session.get(foodsUrl + meal['id'])
                foods = scrapeFoods(page.text)

                foodsData = crawlFoods(foods, session)

                mealData[meal['name']] = {'foods':foodsData}
                session.get(goBackUrl + 'Meals')

            datesData[date['dateString']] = {'meals':mealData}

        session.get(goBackUrl + 'Dates')
    return datesData



if __name__ == "__main__":

    data = {}

    session = requests.session()

    session.get('http://netnutrition.dining.iastate.edu/NetNutrition/1215')

    diningCentersUrl = 'http://netnutrition.dining.iastate.edu/NetNutrition/2015/Mobile/GotoPage?pageName=Units'
    diningCentersPage = session.get(diningCentersUrl)

    centers = scrapeCenters(diningCentersPage.text)

    #remove "all the extras" because it does not have any data right now
    centers = list(filter(lambda x : x['name'] != '"All the Extras"', centers ))

    #get list of stations at each dining center
    unitUrl = 'http://netnutrition.dining.iastate.edu/NetNutrition/2015/Mobile/SelectUnit?oidParm='
    goBackUrl = 'http://netnutrition.dining.iastate.edu/NetNutrition/2015/Mobile/GotoPage?pageName='
    for center in centers:

        print("scraping", center['name'])

        url = unitUrl + center['uid']
        page = session.get(url)
        stations = scrapeStations(page.text)

        # some dining centers do not have differenct stations
        if len(stations) == 0:
            dates = scrapeDates(page.text)
            datesData = crawlDates(dates, session)
            data[center['name']] = {'dates':datesData}
        else:
            stationData = {}
            for station in stations:

                page = session.get(unitUrl + station['uid'])
                dates = scrapeDates(page.text)

                datesData = crawlDates(dates, session)

                stationData[station['name']] = {'dates': datesData}
                session.get(goBackUrl + 'Units')

            data[center['name']] = {'stations':stationData}
        session.get(goBackUrl + 'Units')
       
        



    with open('data.json','w', encoding='utf8') as f:
        json.dump(data, f, sort_keys=True,indent=4, ensure_ascii=False, )

