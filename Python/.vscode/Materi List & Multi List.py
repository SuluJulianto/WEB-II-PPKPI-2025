import os
os.system("cls")

alat_olahraga=[]

for jumlah_alat in range (3):
    print("Masukkan data ke: ", jumlah_alat+1)
    nama_alat=input("Masukkan nama alat olahraga: ")
    alat_olahraga.append(nama_alat)

print("Daftar alat olahraga yang sudah dimasukkan adalah: ")
for data_alat in alat_olahraga:
    print(data_alat)

#append
nama_alat=input("Silahkan tambahkan 1 alat olahraga: ")
alat_olahraga.append(nama_alat)
print(alat_olahraga)

#remove
nama_alat=input("Silahkan hapus 1 alat olahraga: ")
alat_olahraga.remove(nama_alat)
print(alat_olahraga)