import os
import getpass
os.system ("cls")

lokasi="c:/users/public/db_ivan/"
namafile="pengguna.txt"
db=lokasi+namafile

#Menunjukka data tersedia
if os.path.exists(db):
    print("DATA TERSEDIA")
else:
    print("DATA TIDAK TERSEDIA")

benar="t"
while benar=="t" or benar=="T":
    os.system("cls")
    print("SILAHKAN REGISTER")
    print()
    namalengkap=input("Nama Lengkap: ")
    namauser=input("Username: ")
    katasandi=getpass.getpass("PASSWORD: ")
    ulangipass=getpass.getpass("ULANGI PASSWORD: ")

    benar=input("Apakah data sudah benar? (y/t)")

#Membuka data dengan menggunakan variabel bukadata ('a' artinya append/menambahkan data baru)
bukadata=open(db, "a")
if katasandi != ulangipass:
    print("\nUlangi Konfirmasi Password")
    katasandi=getpass.getpass("Password: ")
    ulangipass=getpass.getpass("Ulangi Password: ")
   
listdata=namalengkap+","+namauser+","+katasandi+","+"0"+","+"0"+"\n"
bukadata.write(listdata)
print("REGISTRASI BERHASIL")
bukadata.close()
    