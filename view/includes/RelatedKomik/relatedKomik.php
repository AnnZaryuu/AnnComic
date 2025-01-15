<?php
                    $relatedKomik = $komikModel->getRelatedKomik($komik->genre);
                    foreach ($relatedKomik as $related) {
                        echo "
                        <div class='bg-gray-800 p-4 rounded-lg shadow-lg flex-shrink-0 w-48'>
                            <img src='{$related->image}' alt='{$related->judul}' class='rounded-lg w-full h-60 object-cover'>
                            <h3 class='mt-2 text-center font-semibold text-white'>{$related->judul}</h3>
                        </div>
                        ";
                    }
                    ?>