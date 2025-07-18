import os
import rumus
def bersih_layar():
    os.system('cls')

def notif(isi_notif):
    pesan=input(f"{isi_notif} .. Tekan Enter untuk Selesai") 

pilih=""
while pilih=="" or pilih>"2":
    bersih_layar()
    print("Menu Hitung Rumus")
    print()
    print("1.) Luas Bujur Sangkar")
    print("2.) Luas Segitiga")
    print("0.) Selesai")
    pilih=input("Pilihan anda : ")
    print()

    if pilih=='0' :
        notif("Program berakhir")
        exit()
    elif pilih=="1":
        rumus.bujur_sangkar(10)
        notif("Luas bujur sangkar ditambahkan ..")
        pilih=""
    elif pilih=="2":
        rumus.segitiga(12,20)
        notif("Luas segitiga ditambahkan ..")
        pilih=""

##notif("Data sudah di tambah")
#bersih_layar()

#notif("Data sudah di Edit")
#bersih_layar()

#notif("Data sudah di hapus")
#bersih_layar()



#pesan=input("Data Telah di tambah, tekan enter untuk lanjut")
#bersih_layar()

#pesan=input("Data Telah di edit, tekan enter untuk lanjut")
#bersih_layar()

#pesan=input("Data Telah di hapus, tekan enter untuk lanjut")
#bersih_layar()