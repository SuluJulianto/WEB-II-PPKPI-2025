import os
os.system('cls')

#contoh ke-1
for i in range(10):
    print("Nomor ke: ",i)

#contoh ke-2
buah=["Jeruk","Pisang"]
for item in buah:
    print(item)

#contoh ke-3
toyota= ["Avanza", "Supra", "Kijang"]
jumlahmobil=0
for data in toyota:
    jumlahmobil = jumlahmobil + 1
    print("jenismobil toyota ke:", jumlahmobil)
    print(data)

#contoh ke-4
for jumlahkubus in range(4):
    sisi=int(input("Masukkan sisi kubus: "))
    volume=sisi**3
    print("Volume kubus adalah: ", volume)

#contoh ke-5
adalagi="1"
while adalagi=="1":
    sisi=int(input("Masukkan sisi kubus: "))
    volume=sisi**3
    print("Volume kubus adalah: ", volume)
    adalagi=input("Ketik 1 untuk data lagi berikut ")
print("Pengisian data berakhir")

#kerjakan soal
#for loop
banyak_data = int(input("Berapa banyak data yang ingin dihitung?"))
for i in range(banyak_data):
    sisi=float(input("Masukkan sisi kubus: "))
    cek=input("Apakah data sudah benar? (y/t)")

    if cek.lower() == "y":
        volume=sisi**3
        print("volume kubus adalah")