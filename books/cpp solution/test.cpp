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


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  char skola[1000];
  char razred[1000];
  char predmet[1000];
  char knjiga[1000];
  int count = 0;
  
  for(int i = 0; i < 242400; i++){
    cin.std::istream::getline (s, 1000);

    if(linija_je_skola(s)){
      strcpy(skola, s);
      continue;
    }
    else if(linija_je_razred(s)){
      count++;
      strcpy(razred, s);
      continue;
    }
    else if(linija_je_predmet(s)){
      strcpy(predmet, s);
      continue;
    }
    else if(linija_je_knjiga(s)){
      strcpy(knjiga, s);

      //PRINTAJ
      cout << count;
      cout << ";";
      print(predmet);
      cout << ";";
      print(knjiga);
      cout << endl;
    }
  }

  return 0;
}