#!/bin/bash

# Runner for ancil-top, changes web values to ones ancil_top can use

# Scott Wales 2012

MODELARGS="foo --model test --email test@example.com"

# Get model details
options=$(getopt --longoptions email:,model: -- $MODELARGS)
# Put $options as the command line arguments and parse
eval set -- "$options"
while true
do
    case $1 in
        --email) email=$2; shift;;
        --model) model=$2; shift;;
        --) shift; break;;
        *) echo "Parse error! $1" >&2; exit -1;;
    esac
    shift;
done

: ${model:=anon}
: ${outdir:=$TMPDIR/cap/$model}

mkdir -pv $outdir
cd $outdir

: ${DATASETS:=mask}
export DATASETS

# Set up the run
# Change these variables when porting
export ANCIL_PARENT=/scratch/swales/projects/CAP/CAP
export ANCIL_MASTER=/scratch/UM/ancilmaster
export UMDIR=/scratch/UM/umdir
export VN=8.1

# Generate the CAP script
$ANCIL_PARENT/bin/ancil_top \
    -norun \
    -output $outdir \
    -version $VN

# Fix the script
# Set ANCIL_MASTER
sed -e 's|^\(ANCIL_MASTER\)=.*|\1='$ANCIL_MASTER'|' -i $outdir/make_ancil_file
# Remove ANCIL_RUN_DIR
sed -e '/ANCIL_RUN_DIR/d' -i $outdir/make_ancil_file

# Run the script
#ksh $outdir/make_ancil_file
