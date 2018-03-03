#!/bin/bash

dummySize=(SX S M L XL XXL)
dummyCategory=(1 2 3 4 5 6 7 8 9 10)
dummyManufacturer=('HM' 'Cubus' 'QM' 'dummy1' 'dummy2')
dummytOriginCountry=('Sweden' 'Denmark' 'Finland' 'Norway' 'Germany' 'New Zealand')
dummyColor=('Pink' 'Purple' 'Green' 'Blue' 'Yellow' 'Cyan')
dummyComplete=()
#COUNTERALL=0
for i in `seq 1 2000`;
do
    RANDOMSIZE=$(( ( RANDOM % 6 ) ))
    RANDOMCATEGORY=$(( ( RANDOM % 3 ) ))
    RANDOMMANUFACTURER=$(( ( RANDOM % 5 ) ))
    RANDOMORIGIN=$(( ( RANDOM % 6 ) ))
    RANDOMWEIGHT=$(( ( RANDOM % 1000) + 200 ))
    RANDOMSELLPRIZE=$(( ( RANDOM % 2000) + 70 ))
    RANDOMBUYPRIZE=$(( ( RANDOM % 1000) + 70 ))
    RANDOMCOLOR=$(( ( RANDOM % 6 ) ))
    RANDOMAMOUNT=$(( ( RANDOM % 200 ) + 1 ))

    dummyComplete+=("
    ${dummyManufacturer[RANDOMMANUFACTURER]},
    'En fin insert here',
    ${dummytOriginCountry[RANDOMORIGIN]},
    ${RANDOMWEIGHT}, ${dummySize[RANDOMSIZE]},
    ${RANDOMSELLPRIZE}, ${RANDOMBUYPRIZE},
    ${dummyColor[RANDOMCOLOR]},
    ${RANDOMAMOUNT},
    ${dummyCategory[RANDOMCATEGORY]}
    ")
    #echo The counter is $COUNTERALL
    #let COUNTERALL=COUNTERALL+1
done
