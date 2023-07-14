#!/bin/bash

env=null
# $# 参数个数
if [[ $# -ge 1 ]]; then
    env=$1
fi

code_path=$(cd `dirname $0`; pwd)
code_dir=`basename ${code_path}`

project=${code_dir}
if [[ -z "${project}" ]]; then
    project=${code_dir}
fi
tar_file="${project}.tar.gz"


#cd ${code_path}
if [[ ! "${env}" = "local" ]]; then
    composer install --no-dev --no-progress --optimize-autoloader
else
    composer install
fi

cd ..

rm -rf "${tar_file}"

# 排除目录
log_path="${code_dir}/storage/logs/"
git_path="${code_dir}/.git"
idea_file="${code_dir}/.idea"


gtar -czf "${tar_file}" \
 --exclude="${log_path}" \
 --exclude="$git_path" \
 --exclude="$idea_file" \
 --no-xattrs \
 "${code_dir}"

echo "打包结束"
