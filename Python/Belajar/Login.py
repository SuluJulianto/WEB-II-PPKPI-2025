import os
import getpass
os.system ('cls')

lokasi="c:/users/public/db_ivan/"
namafile="pengguna.txt"
db=lokasi+namafile

#Menunjukka data tersedia
if os.path.exists(db):
    print("DATA TERSEDIA")
else:
    print("DATA TIDAK TERSEDIA")



print("SILAHKAN LOGIN")
print()

#Melakukan isi data, jika tidak mengisi akan keluar tulisan tidak boleh kosong(terjadi pengulangan)
userisi=False
while userisi==False:
    cekuser=input("USER NAME: ")
    if cekuser=="":
        print("USERNAME TIDAK BOLEH KOSONG")
        userisi=False
    else:
        userisi=True

sandi_isi=False
while sandi_isi==False:
    ceksandi=getpass.getpass("PASSWORD: ")
    if ceksandi=="":
        print("PASSWORD TIDAK BOLEH KOSONG")
        sandi_isi=False
    else:
        sandi_isi=True
    

#Membuka data dan membacanya menggunakan variabel bukadata ('r' artinya read)
bukadata=open(db,'r')

#Mencari/cek data pengguna meliputi nama lengkap, username, sandi, dll, menggunakan variabel caridata
for caridata in bukadata:
    kolom=caridata.strip().split(",")
    namalengkap=kolom[0]
    username=kolom[1]
    katasandi=kolom[2]
    admin=kolom[3]
    aktif=kolom[4]

#Mengecek username & password apakah benar/salah, jika berhasil/benar akan lanjut ke bagian menu
    if username==cekuser and katasandi==ceksandi and aktif=="1":
        pesan=input("Berhasil ..... tekan ENTER untuk lanjut .....")
        os.system("cls")
        print("Menu Penggolahan Pengguna")
        print()
        print("1. Profil Pengguna")
        print("2. List Pengguna")
        print("3. Edit Pengguna")
        print("4. Hapus Pengguna")
        print("5. Otorisasi Pengguna")
        print("6. Selesai")
    else:
        print("TIDAK BERHASIL")
        exit()

