#Latihan soal if, elif, else
#1.) Payung & Hujan
cuaca = input("Bagaimana cuacanya hari ini? (hujan/cerah): ")
if  cuaca == "hujan":
    print("Bawa Payung")
elif cuaca == "cerah":
    print("Tak perlu payung")
else:
    print("cuaca tidak dikenali")

#2.) Tebak Bilangan
angka_rahasia = 17
tebakan = int(input("\nTebak angka antara 1-20: "))
if tebakan == angka_rahasia:
    print("Tebakanmu tepat!")
elif tebakan < angka_rahasia:
    print("Terlalu kecil")
else:
    print("Terlalu besar")


#3.) Diskon Belanja
total = int(input("\nTotal belanja= Rp "))

if total >= 300000:
    diskon = 0.20
elif total >= 200000:
    diskon = 0.10
elif total >= 100000:
    diskon = 0.05
else:
    diskon = 0.0

harga_diskon = total * diskon
total_harga_akhir = total - harga_diskon

print("Nilai diskon= Rp", float(harga_diskon))
print("Total bayar akhir= Rp", float(total_harga_akhir)) 


#4.) Kategori Nilai Huruf
nilai = int(input("\nMasukkan nilai kamu (0-100): "))
if nilai > 100 or nilai < 0:
    print("Nilai tidak valid")
elif nilai >=85:
    print("Nilai kamu A")
elif nilai >=70:
    print("Nilai kamu B")
elif nilai >=55:
    print("Nilai kamu C")
elif nilai >=40:
    print("Nilai kamu D")
else:
    print("Nilai kamu E")

#5.) Tahun Kabisat
tahun = int(input("\nMasukkan tahun kabisat: "))

if (tahun % 4 == 0 and tahun % 100 !=0) or (tahun % 400 == 0):
    print(tahun, "adalah tahun kabisat")
else:
    print(tahun, "bukan tahun kabisat")

print("\nProgram selesai. Terima kasih")