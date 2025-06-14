<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe
        ];
    }
    public static function flash()
    {
        if( isset($_SESSION['flash']) ) {
            $bgColor = 'bg-gray-100';
            $textColor = 'text-gray-800';
            $borderColor = 'border-gray-200';

            switch($_SESSION['flash']['tipe']) {
                case 'success':
                    $bgColor = 'bg-green-100';
                    $textColor = 'text-green-800';
                    $borderColor = 'border-green-200';
                    break;
                case 'danger':
                    $bgColor = 'bg-red-100';
                    $textColor = 'text-red-800';
                    $borderColor = 'border-red-200';
                    break;
                case 'warning':
                    $bgColor = 'bg-yellow-100';
                    $textColor = 'text-yellow-800';
                    $borderColor = 'border-yellow-200';
                    break;
                case 'info':
                    $bgColor = 'bg-blue-100';
                    $textColor = 'text-blue-800';
                    $borderColor = 'border-blue-200';
                    break;
            }
            
            echo '<div class="rounded-md border ' . $borderColor . ' ' . $bgColor . ' px-4 py-3 absolute mb-4" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 ' . $textColor . ' mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold ' . $textColor . '">Catatan <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '</p>
                        </div>
                    </div>
                    <button type="button" class="absolute top-0 right-0 mt-2 mr-2 ' . $textColor . '" onclick="this.parentElement.style.display=\'none\';" aria-label="Close">
                        <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </button>
                </div>';
            unset($_SESSION['flash']); // Hapus flash message setelah ditampilkan
        }
    }
}