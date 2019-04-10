#include <bits/stdc++.h>
#include <iostream> 

using namespace std;

bool linija_je_skola(char c[]) {
  
  string s(c);
 
  size_t found = s.find("Mišljenje");

  if(found != std::string::npos){
    return true;
  }
  else{
    return false;
  }

}

bool linija_je_razred(char s[]){
  
  string k(s);
   
  size_t found = k.find("razred");
  size_t found2 = k.find(";;;;;;;");

  int count = 0;

  for(int i = 0; s[i] != '\0'; i++){
    if(s[i] == '-') count++;
  }

  if(count >= 2  && !isdigit(s[0])  && !isupper(s[1]) && !isupper(s[2])){
    return true;
  }
  else if(found != std::string::npos && found2 != std::string::npos){
    return true;
  }
  else{
    return false;
  }

}

bool linija_je_predmet(char s[]){
  string k(s);
  
  size_t found = k.find(";;;;;;;");

  if(found != std::string::npos && isupper(s[0]) && isupper(s[1])){
    return true;
  }
  else{
    return false;
  }

}

bool linija_je_knjiga(char s[]){
  
  if(isdigit(s[0]) && (s[1] == ';' || (isdigit(s[1])))){
    return true;
  }
  else{
    return false;
  }
}

void print(char s[]){
	for(int i = 0; i < 10000; i++){
		if(s[i] == ';') return;
		else cout << s[i];
	}
}

bool CheckWord(char* filename, string search){

  int offset; 
  string line;
  ifstream Myfile;
  Myfile.open (filename);

  if(Myfile.is_open()){

      while(!Myfile.eof()){

          getline(Myfile,line);
          if ((offset = line.find(search, 0)) != string::npos){
           return true;
          }  

      }

      Myfile.close();
      
  }  

  return false;
}


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  char skola[1000];
  char razred[1000];
  char predmet[1000];
  char knjiga[1000];
  bool flag = false;
  int count = 885;
  int idGrade = 8048;
  
  for(int i = 0; i < 242400; i++){
  	cin.std::istream::getline (s, 1000);

  	if(linija_je_skola(s)){
  		strcpy(skola, s);

      // Ova skola vec postoji u bazi, preskaci sve
      string tmp(s);  
      if(CheckWord("skole_koje_se_ponavljaju.txt", tmp.substr(0, tmp.find(";")))){      
        flag = true;
      }
      else {
        flag = false;
        count++;
      }

  		continue;
  	}

  	else if(linija_je_razred(s)){
  		//count++;
  		strcpy(razred, s);
      
      if(!flag){
        idGrade++;
      }

  		continue;
  	}

  	else if(linija_je_predmet(s)){
  		strcpy(predmet, s);
  		continue;
  	}

  	else if(linija_je_knjiga(s)){
  		strcpy(knjiga, s);

  		//PRINTAJ
      if(!flag){
        cout << idGrade << ";";   
        print(predmet);
        cout << ";";
        print(knjiga);
        cout << endl;        
      }


      //cout << knjiga << endl;
  	}
  }

  return 0;
}