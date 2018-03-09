#!/bin/bash

echo "How many products do you want? (1+) (Press Enter to continue)"
read amount

dummySize=(XS S M L XL XXL)
dummyCategoryName=('' '' '' '' '' '' '' '' '' '' '' '' 'Shorts' 'Jeans' 'Träningsbyxa' 'Trosa' 'BH' 'Nattlinne' 'T-shirt' 'Sweatshirt' 'Cardigan' 'Linne' 'Långklänning' 'Korta klänning' 'Vinterjacka' 'Skinnjacka' 'Jacka' 'Skinnväska' 'Ryggsäck' 'Shorts' 'Jeans' 'Träningsbyxa' 'T-shirt' 'Sweatshirt' 'Cardigan' 'Linne' 'Y-front' 'Boxershort' 'Vinterjacka' 'Skinnjacka' 'Jacka' 'Kostym' 'Skinnväska' 'Ryggsäck')
dummyManufacturer=('HM' 'Cubus' 'GANT' 'Jack&Jones' 'Levi' 'Adrian Hammond')
dummytOriginCountry=('Sverige' 'Danmark' 'Finland' 'Norge' 'Tyskland' 'Nya Zeeland')
dummyColor=('Rosa' 'Lila' 'Grön' 'Blå' 'Gul' 'Ljusblå' 'Vit' 'Svart')
dummyComplete=('INSERT INTO Product(`productManufacturer`, `productName`, `productOriginCountry`, `productWeight`, `productSize`, `productSellPrize`, `productBuyPrize`, `productColor`, `productAmount`, `productCategoryID`) VALUES ')


for _ in $(seq 1 ${amount});
do
    RANDOMSIZE=$(( ( RANDOM % 6 ) ))
    RANDOMCATEGORY=$(( ( RANDOM % 32 ) + 12 ))
    RANDOMCATEGORYID=$(( ( $RANDOMCATEGORY )))
    RANDOMMANUFACTURER=$(( ( RANDOM % 6 ) ))
    RANDOMORIGIN=$(( ( RANDOM % 6 ) ))
    RANDOMWEIGHT=$(( ( RANDOM % 1000 ) + 200 ))
    RANDOMBUYPRIZE=$(( ( RANDOM % 1000 ) + 70 ))
    RANDOMSELLPRIZE=$(( ( RANDOM % 2000 ) + $RANDOMBUYPRIZE ))
    RANDOMCOLOR=$(( ( RANDOM % 8 ) ))
    RANDOMAMOUNT=$(( ( RANDOM % 200 ) + 1 ))

    dummyComplete+=("
    ("\"${dummyManufacturer[RANDOMMANUFACTURER]}"\",
    "\"${dummyManufacturer[RANDOMMANUFACTURER]} ${dummyColor[RANDOMCOLOR]} ${dummyCategoryName[RANDOMCATEGORY]}"\",
    "\"${dummytOriginCountry[RANDOMORIGIN]}"\",
    ${RANDOMWEIGHT},
    "\"${dummySize[RANDOMSIZE]}"\",
    ${RANDOMSELLPRIZE},
    ${RANDOMBUYPRIZE},
    "\"${dummyColor[RANDOMCOLOR]}"\",
    ${RANDOMAMOUNT},
    ${RANDOMCATEGORY}),
    ")
    #echo The counter is $COUNTERALL
    #let COUNTERALL=COUNTERALL+1

    # echo $RANDOMCATEGORY >> test.txt
done

echo ${dummyComplete[@]} | sed -e '$s/,$//' > dummy_data.sql
