# Copyright (C) 2021 Luca Gasperini <luca.gasperini@xsoftware.it>
#
# This file is part of hsmeme.net.
#
# hsmeme.net is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# hsmeme.net is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with hsmeme.net.  If not, see <http://www.gnu.org/licenses/>.

project(hsmeme_dotnet)

cmake_minimum_required(VERSION 3.9)

include(GNUInstallDirs)

set (HSMEME_WWW_DIR "${CMAKE_INSTALL_LOCALSTATEDIR}/www/hsmeme.net/")


set (hsmeme_sources
    index.php
    cardbuilder.php
    render.php
    data.php
    utils.php
    config.example.php
)

set (hsmeme_css
    css/style.css
)

set (hsmeme_bootstrap
    bootstrap/
)

set (hsmeme_fontawesome
    fontawesome/
)

install(FILES ${hsmeme_sources}
    DESTINATION ${HSMEME_WWW_DIR}
)
install(FILES ${hsmeme_css}
    DESTINATION ${HSMEME_WWW_DIR}
)

install(DIRECTORY ${hsmeme_bootstrap}
    DESTINATION ${HSMEME_WWW_DIR}/bootstrap
)

install(DIRECTORY ${hsmeme_fontawesome}
    DESTINATION ${HSMEME_WWW_DIR}/fontawesome
)