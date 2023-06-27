for i in range(10): 
  values = ", \n".join([
		f'("Alex {j}", "alex{j}gmail.com", "123")'
		for j in range(10000 * i, 10000 * (i +1))
	])
  
  print(f"INSERT INTO users(name, email, password) VALUES {values};")

