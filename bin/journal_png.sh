#!/bin/bash
echo $#
if [ $# -eq 0 ]; then
    echo "Usage:"
    echo "$ cd content/magazine/pdf/"
    echo "$ ./journal_png.sh issue_number"
else
    base_filename="sdn_journal_"$1
    pdf_filename=$base_filename".pdf"
    # pdf_filename="content/magazine/pdf/"$pdf_filename
    echo $pdf_filename
    if [ -f $pdf_filename ]; then
        convert $pdf_filename[0] -resize 100x $base_filename".png"
        convert $pdf_filename[0] -resize 150x $base_filename"_150.png"
        echo "def"
    else
        echo "Error:" $pdf_filename "does not exist"
    fi
fi;
# convert sdn_journal_73.pdf[0] -resize 150x sdn_journal_73_150.png
