#!/bin/bash

for file in `ls *.html`
do
	replace="pdf"
	wkhtmltopdf "$file" ${file//html/$replace}
done
rm *.html