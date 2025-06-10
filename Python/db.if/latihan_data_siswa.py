import os
os.system("cls")

#Membuka & membaca file siswa.txt
with open("siswa.txt", "r") as file:
    data = file.readlines()

lulus = 0
gagal = 0
grade_a = 0
grade_b = 0
grade_c = 0
grade_d = 0

#Tabel
judul=f"{'Laporan Data Nilai Siswa Kelas 5 SD Literasi Cerah':^58}"
print(judul)
tabel=f"{'No':4} {'Nama Siswa':18} {'Teori':5} {'Praktek':7} {'Final':5} {'Keterangan':10} {'Grade':5}"
print(tabel)

#print("No   Nama Siswa        Teori Praktek  Final  Ktr     Grade")
print("--   -----------        ----  -----   -----  ------   -----")

#proses tiap baris
for i, baris in enumerate(data):
    nama, teori, praktek = baris.strip().split(",")
    teori=int(teori)
    praktek=int(praktek)
    final=(teori + praktek) / 2

#Hasil lulus atau gagal
    if final > 70:
        keterangan="Lulus"
        lulus += 1
    else:
        keterangan="Gagal"
        gagal += 1

#Menentukan grade
    if final > 90:
        grade = "A"
        grade_a += 1
    elif final > 80:
        grade = "B"
        grade_b += 1
    elif final > 70:
        grade = "C"
        grade_c += 1
    else:
        grade = "D"
        grade_d += 1

    # Hasil
    print(f"{i+1:<4} {nama:<19} {teori:<6} {praktek:<6} {final:<7.1f} {keterangan:<9} {grade:}")

print("-"*50)
print(f"Siswa Lulus: {lulus} orang")
print(f"Siswa Gagal: {gagal} orang")
print("-"*50)
print(f"Peserta Grade A: {grade_a} orang")
print(f"Peserta Grade B: {grade_b} orang")
print(f"Peserta Grade C: {grade_c} orang")
print(f"Peserta Grade D: {grade_d} orang")
print("-"*50)
print(f"Jumlah Seluruh Siswa: {len(data)} orang")
